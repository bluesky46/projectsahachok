# ระบบ POS ร้านขายหลังคาเหล็ก — เอกสาร Requirement

> **สถานะ:** เอกสารนี้เป็น **As-Is (สภาพปัจจุบัน)** ที่ได้จากการ *reverse-engineer จากโค้ดที่มีอยู่จริง*
> ไม่ใช่ requirement ที่ออกแบบไว้ล่วงหน้า เพราะโปรเจกต์ **ยังไม่มีเอกสาร requirement ตั้งต้น**
> ใช้เป็นฐานเพื่อระบุ requirement ที่ชัดเจน (To-Be) ต่อไป
>
> 🔴 = จุดที่โค้ดปัจจุบันทำ "ผิดมาตรฐาน" หรือมีความเสี่ยง (ดูหัวข้อ Gap ท้ายเอกสาร)

---

## 1. ผู้เกี่ยวข้องกับระบบ (As-Is Actors & Context)

ระบบปัจจุบันมีผู้ใช้ 4 กลุ่ม แต่ **การคุมสิทธิ์ยังไม่สมบูรณ์**

```mermaid
graph TB
    subgraph external["ผู้ใช้ระบบ"]
        staff["👤 พนักงานขาย / Guest<br/>(ขายหน้าร้าน)"]
        admin["👤 Admin<br/>(is_admin = 1)"]
        rider["👤 Rider<br/>(role = 'rider')"]
        customer["👤 ลูกค้า<br/>(เป็นข้อมูล ไม่ได้ login)"]
    end

    subgraph system["ระบบ POS (Laravel 9)"]
        pos["🛒 โมดูลขายหน้าร้าน<br/>Cart / Checkout"]
        prod["📦 โมดูลสินค้า & สต็อก"]
        adminmod["📊 โมดูล Admin<br/>Dashboard / จัดการสิทธิ์"]
        delivery["🚚 โมดูลจัดส่ง<br/>Shipping / Rider"]
    end

    db[("🗄️ MySQL<br/>projectseminar")]

    staff -->|"ไม่ต้อง login 🔴"| pos
    staff --> prod
    admin -->|"auth + is_admin"| adminmod
    admin --> prod
    admin --> delivery
    rider -->|"auth (แต่ไม่เช็ค role 🔴)"| delivery
    customer -.->|"ถูกบันทึกตอน checkout"| pos

    pos --> db
    prod --> db
    adminmod --> db
    delivery --> db
```

| Actor | วิธียืนยันตัวตนปัจจุบัน | สิ่งที่ทำได้ | ปัญหา |
|-------|----------------------|------------|-------|
| พนักงานขาย | **ไม่มี** (route เปิดโล่ง) | เปิดตะกร้า, ขาย, ตัดสต็อก | 🔴 ใครก็เข้าได้โดยไม่ login |
| Admin | `auth` + middleware `is_admin` | Dashboard, จัดการ user/สิทธิ์, สต็อก, จัดส่ง | โอเค |
| Rider | `auth` เท่านั้น | ดูออเดอร์, ยืนยันจัดส่ง, อัปโหลดรูป | 🔴 route ไม่เช็ค `role='rider'` |
| ลูกค้า | ไม่ login | ถูกบันทึกด้วยเบอร์โทรตอน checkout | 🔴 ผูกด้วยเบอร์ ไม่ใช่ id |

---

## 2. Flow การขายหน้าร้าน (As-Is Sale / POS Flow)

flow จริงตามที่โค้ดใน `CartController` ทำ — รวมจุดบกพร่องที่พบ

```mermaid
flowchart TD
    start([พนักงานเปิดหน้าขาย]) --> browse["เลือกสินค้า<br/>(filter category/brand/supplier)"]
    browse --> add["POST /cart/add<br/>CartController::add()"]
    add --> checkcus{"กรอกเบอร์ลูกค้า?"}
    checkcus -->|มี| whole["เช็ค canUseWholesale()<br/>→ ตัดสินราคาส่ง/ปลีก"]
    checkcus -->|ไม่มี| retail["ใช้ราคาปลีก"]
    whole --> cartrow["บันทึกลง carts<br/>(ผูกกับ session_id)"]
    retail --> cartrow
    cartrow --> more{"เพิ่มสินค้าอีก?"}
    more -->|ใช่| browse
    more -->|ไม่| checkout["POST /cart/checkout<br/>🔴 ไม่มี validation<br/>🔴 ไม่มี DB transaction"]

    checkout --> createorder["สร้าง Order"]
    createorder --> loop["วนแต่ละรายการในตะกร้า"]
    loop --> stockchk{"สต็อกพอ?"}
    stockchk -->|ไม่พอ| fail["return back()<br/>🔴 Order + รายการก่อนหน้า<br/>ถูกบันทึกไปแล้ว = ข้อมูลพัง"]
    stockchk -->|พอ| detail["สร้าง OrderDetail<br/>+ decrement stock<br/>+ StockMovement (out)"]
    detail --> loop
    loop --> cleardone["ล้างตะกร้า"]
    cleardone --> deliv{"is_delivery?"}
    deliv -->|ใช่| pending["status = pending_delivery<br/>→ เข้าคิว Rider"]
    deliv -->|ไม่| complete["status = completed"]
    pending --> done([จบ])
    complete --> done
```

---

## 3. Flow การจัดส่ง (As-Is Delivery / Rider Flow)

```mermaid
flowchart LR
    o["Order<br/>status = pending_delivery"] --> ship["Admin: /shippingblade<br/>ดูรายการรอส่ง"]
    ship --> assign["Rider เห็นใน /rider<br/>RiderController::dashboard"]
    assign --> view["/rider/order/{id}<br/>ดูรายละเอียด"]
    view --> upload["POST /rider/order/{id}/complete<br/>อัปโหลดรูปหลักฐาน (delivery_image)"]
    upload --> proof["Admin ตรวจสอบหลักฐาน<br/>/admin/order/proof"]
    proof --> finish["status → completed"]
```

---

## 4. โครงสร้างข้อมูลปัจจุบัน (As-Is ERD)

ERD จากตารางและ relationship จริงในโค้ด (21 ตาราง แสดงเฉพาะแกนหลัก)

```mermaid
erDiagram
    CATEGORIES  ||--o{ BRANDS         : "มี"
    CATEGORIES  ||--o{ PRODUCT_ITEMS  : "จัดกลุ่ม"
    BRANDS      ||--o{ PRODUCT_ITEMS  : "ยี่ห้อ"
    SUPPLIERS   ||--o{ PRODUCT_ITEMS  : "ผู้ขายส่ง"
    UNITS       ||--o{ PRODUCT_ITEMS  : "หน่วยนับ"
    PRODUCT_ITEMS ||--o{ PRODUCTS     : "master → รายการขาย"
    PRODUCTS    ||--o{ CARTS          : "อยู่ในตะกร้า"
    PRODUCTS    ||--o{ ORDER_DETAILS  : "ถูกสั่ง"
    PRODUCTS    ||--o{ STOCK_MOVEMENTS: "เคลื่อนไหวสต็อก"
    ORDERS      ||--o{ ORDER_DETAILS  : "มีรายการ"
    CUSTOMERS   ||--o{ ORDERS         : "สั่งซื้อ (ผูกด้วยเบอร์โทร 🔴)"
    USERS       ||--o{ LOGIN_HISTORIES: "ประวัติ login"

    PRODUCT_ITEMS {
        bigint id PK
        string item_name
        decimal retail_price
        decimal wholesale_price
        bigint category_id FK
        bigint brand_id FK
        bigint supplier_id FK
    }
    PRODUCTS {
        bigint id PK
        string product_code
        bigint product_item_id FK
        int stock_quantity
    }
    CARTS {
        bigint id PK
        string session_id "ผูกด้วย session ไม่ใช่ user 🔴"
        bigint product_id FK
        int quantity
        string price_type
    }
    ORDERS {
        bigint id PK
        decimal total_price
        string status "pending / pending_delivery / completed"
        string customer_phone "FK แบบเบอร์โทร 🔴"
        boolean is_delivery
        string delivery_image
    }
    ORDER_DETAILS {
        bigint id PK
        bigint orders_id FK
        bigint product_id FK
        int quantity
        decimal unit_price
        decimal total_price_with_vat "VAT 7% hardcode 🔴"
    }
    CUSTOMERS {
        bigint id PK
        string name
        string phone
        string type "ทั่วไป / ร้านค้า / ช่าง"
        boolean is_wholesale
    }
    USERS {
        bigint id PK
        string name
        string email
        boolean is_admin
        string role "rider ฯลฯ"
    }
```

---

## 5. โมดูลในระบบปัจจุบัน (As-Is Module Map)

```mermaid
mindmap
  root((POS<br/>หลังคาเหล็ก))
    ขายหน้าร้าน
      Cart (session-based)
      Checkout
      คิดราคาส่ง/ปลีกอัตโนมัติ
    สินค้า & สต็อก
      ProductItem (master)
      Product (รายการขาย)
      StockMovement
      Category/Brand/Supplier/Unit
    Admin
      Dashboard ยอดขาย
      จัดการสิทธิ์ user
      รายงานสินค้าขายดี
    จัดส่ง
      Shipping list
      Rider ยืนยันส่ง + รูป
    ลูกค้า
      บันทึกลูกค้า
      Loyalty / ประเภทลูกค้า
```

---

## 6. Gap Analysis — ทำไม requirement ถึง "ยังไม่ชัด"

ปัญหาที่ทำให้ระบบยัง**ไม่เป็นมาตรฐาน** และ requirement ยังไม่ครบ:

### 6.1 ความปลอดภัย / ความถูกต้องของข้อมูล (ร้ายแรง)
- 🔴 route ขาย/สต็อก (`/cart/checkout`, `/order/store`, `/stock/add`) **เปิดโล่งไม่ต้อง login**
- 🔴 `checkout()` **ไม่มี DB transaction** → ถ้าสต็อกไม่พอกลางคัน จะเกิดออเดอร์ผี + สต็อกถูกหักทิ้ง
- 🔴 check-then-decrement สต็อก ไม่ atomic → **ขายเกินจำนวน** ได้เมื่อขายพร้อมกัน
- 🔴 แทบไม่มี input validation (qty ติดลบ/ค่าเกินก็ผ่าน)

### 6.2 สถาปัตยกรรม
- ไม่มี Service / Repository layer — business logic ยัดใน controller
- ไม่มี Form Request — validation กระจัดกระจาย
- VAT 7% hardcode (`1.07`) แทนที่จะเก็บใน setting
- ระบบสิทธิ์ใช้แค่ boolean/string ไม่มี Policy/Gate

### 6.3 ประสบการณ์ใช้งาน (UI/UX)
- 🔴 **ไม่มี pagination เลยทั้งโปรเจกต์** — ทุกหน้า list ดึงทั้งตาราง
- Layout 4 ตัวตีกัน (`app` / `sidebar` / `adminside` / `product2`) → หน้าตาไม่สม่ำเสมอ
- ไม่มี Blade component / `@include` เลย → ไม่มีการ reuse
- CSS ฝัง `<style>` ใน 25/46 view → สไตล์เพี้ยนกันแต่ละหน้า

### 6.4 ความสมบูรณ์ของเอกสาร
- ไม่มี Functional / Non-functional requirement ที่เขียนไว้
- ไม่มีนิยาม actor / สิทธิ์ที่ชัดเจน
- ไม่มี state ของ order ที่นิยามครบ (มี pending, pending_delivery, completed ปนกันในโค้ด)
- ไม่มีเทสยืนยันว่า flow ทำงานถูก (มีแค่ ExampleTest)

---

## 7. ข้อเสนอสิ่งที่ requirement (To-Be) ควรระบุให้ชัด

1. **นิยาม actor + สิทธิ์** ให้ครบ (พนักงานขายต้อง login, rider ต้องเช็ค role)
2. **นิยาม state ของ order** เป็น state machine ที่ชัดเจน
3. **Non-functional:** รองรับข้อมูลกี่แถว, ต้องมี pagination, เวลาตอบสนอง
4. **กฎธุรกิจ:** เงื่อนไขราคาส่ง/ปลีก, VAT, loyalty ให้เขียนเป็นข้อกำหนด ไม่ใช่ฝังในโค้ด
5. **ความปลอดภัย:** ทุก transaction เงิน/สต็อกต้อง atomic + auth

> ขั้นถัดไป: เมื่อยืนยัน As-Is นี้แล้ว ดู **To-Be (ระบบที่เสนอ)** ด้านล่างเพื่อเห็นว่าต้องปรับตรงไหนบ้าง

---
---

# 🎯 To-Be — ระบบ POS ที่เสนอ (Proposed System)

> ส่วนนี้คือ **ข้อเสนอการยกระดับระบบ** จาก As-Is ให้เป็นมาตรฐาน
> 🟢 = จุดที่ปรับปรุงจากของเดิม (แก้ 🔴 ใน As-Is)

---

## 8. ภาพรวมสถาปัตยกรรมที่เสนอ (To-Be Architecture)

เปลี่ยนจาก "logic ยัดใน controller" เป็นสถาปัตยกรรมแบบมี layer ชัดเจน

```mermaid
graph TB
    subgraph client["ผู้ใช้ (ต้อง Login ทุกกลุ่ม 🟢)"]
        cashier["👤 พนักงานขาย"]
        admin["👤 Admin"]
        rider["👤 Rider"]
    end

    subgraph app["Laravel Application"]
        direction TB
        route["Routes + Middleware<br/>🟢 auth / role ครบทุก route"]
        fr["Form Requests<br/>🟢 validate ทุก input"]
        ctrl["Controllers (บาง)<br/>รับ request → เรียก service"]
        subgraph services["Service Layer 🟢"]
            possvc["SaleService<br/>(checkout + transaction)"]
            stocksvc["StockService<br/>(lock + ตัดสต็อก)"]
            pricesvc["PricingService<br/>(ส่ง/ปลีก + VAT)"]
        end
        repo["Repository / Eloquent Models"]
        policy["Policies / Gates 🟢<br/>คุมสิทธิ์"]
    end

    db[("🗄️ MySQL<br/>+ transaction + lock")]

    cashier --> route
    admin --> route
    rider --> route
    route --> policy
    route --> fr
    fr --> ctrl
    ctrl --> services
    services --> repo
    repo --> db
```

---

## 9. Flow การขายที่เสนอ (To-Be Sale Flow)

แก้ปัญหา As-Is: ต้อง login, มี validation, ห่อ transaction, ล็อกสต็อก

```mermaid
flowchart TD
    start([พนักงาน login 🟢]) --> browse["เลือกสินค้า<br/>(ค้นหา + filter + pagination 🟢)"]
    browse --> add["เพิ่มลงตะกร้า<br/>🟢 ผูกกับ user_id + validate qty"]
    add --> more{"เพิ่มอีก?"}
    more -->|ใช่| browse
    more -->|ไม่| review["ทบทวนตะกร้า + เลือกลูกค้า"]
    review --> checkout["กดชำระเงิน<br/>🟢 Form Request validate"]

    checkout --> tx["🟢 เริ่ม DB Transaction"]
    tx --> lock["🟢 lockForUpdate() สต็อกทุกตัว"]
    lock --> chkall{"สต็อกพอครบทุกตัว?"}
    chkall -->|ไม่พอ| rollback["🟢 ROLLBACK<br/>ไม่มีข้อมูลค้าง แจ้ง error"]
    chkall -->|พอ| write["สร้าง Order + OrderDetail<br/>+ ตัดสต็อก + StockMovement"]
    write --> commit["🟢 COMMIT ทีเดียว"]
    rollback --> back([กลับหน้าตะกร้า])
    commit --> receipt["ออกใบเสร็จ / PDF"]
    receipt --> deliv{"ต้องจัดส่ง?"}
    deliv -->|ใช่| pending["status = AWAITING_DELIVERY"]
    deliv -->|ไม่| done["status = COMPLETED"]
    pending --> fin([จบ])
    done --> fin
```

---

## 10. State ของ Order ที่เสนอ (To-Be Order State Machine)

นิยาม state ให้ชัด (As-Is มี status ปนกันในโค้ด)

```mermaid
stateDiagram-v2
    [*] --> DRAFT: เปิดตะกร้า
    DRAFT --> COMPLETED: ชำระเงิน (ไม่ส่ง)
    DRAFT --> AWAITING_DELIVERY: ชำระเงิน (จัดส่ง)
    AWAITING_DELIVERY --> OUT_FOR_DELIVERY: Rider รับงาน
    OUT_FOR_DELIVERY --> DELIVERED: อัปโหลดหลักฐาน
    DELIVERED --> COMPLETED: Admin ตรวจผ่าน
    AWAITING_DELIVERY --> CANCELLED: ยกเลิก
    OUT_FOR_DELIVERY --> CANCELLED: ยกเลิก
    COMPLETED --> [*]
    CANCELLED --> [*]
```

---

## 11. สิทธิ์การใช้งานที่เสนอ (To-Be Role & Permission)

```mermaid
graph LR
    subgraph roles["Role (ผ่าน Policy/Gate 🟢)"]
        cashier["พนักงานขาย"]
        admin["Admin"]
        rider["Rider"]
    end

    cashier --> pos["ขาย / ตะกร้า / ดูสินค้า"]
    admin --> pos
    admin --> manage["จัดการสินค้า/สต็อก"]
    admin --> report["รายงาน / Dashboard"]
    admin --> users["จัดการ user & สิทธิ์"]
    admin --> approve["อนุมัติหลักฐานจัดส่ง"]
    rider --> mydeliv["🟢 เห็นเฉพาะงานส่งของตัวเอง"]
    rider --> upload["อัปโหลดหลักฐานส่ง"]
```

| Role | เข้าถึงได้ | ปรับจาก As-Is |
|------|-----------|---------------|
| พนักงานขาย | POS, ตะกร้า, ดูสินค้า | 🟢 บังคับ login (เดิมเปิดโล่ง) |
| Admin | ทุกอย่าง + จัดการระบบ | คงเดิม แต่ใช้ Policy |
| Rider | เฉพาะงานส่งของตัวเอง | 🟢 เช็ค role + เห็นเฉพาะงานตัวเอง |

---

## 12. ERD ที่เสนอ (To-Be — จุดที่ปรับ)

```mermaid
erDiagram
    USERS       ||--o{ ORDERS         : "พนักงานที่ขาย 🟢"
    USERS       ||--o{ DELIVERIES     : "rider ที่ส่ง 🟢"
    CUSTOMERS   ||--o{ ORDERS         : "🟢 ผูกด้วย customer_id (ไม่ใช่เบอร์)"
    ORDERS      ||--o{ ORDER_DETAILS  : "มีรายการ"
    ORDERS      ||--o| DELIVERIES     : "งานจัดส่ง 🟢"
    PRODUCTS    ||--o{ ORDER_DETAILS  : "ถูกสั่ง"
    PRODUCTS    ||--o{ STOCK_MOVEMENTS: "เคลื่อนไหวสต็อก"
    SETTINGS    ||--|| SETTINGS       : "🟢 เก็บ VAT/กฎราคา"

    ORDERS {
        bigint id PK
        bigint customer_id FK "🟢 เปลี่ยนจาก phone"
        bigint user_id FK "🟢 พนักงานที่ขาย"
        decimal total_price
        string status "🟢 ตาม state machine"
    }
    DELIVERIES {
        bigint id PK
        bigint order_id FK
        bigint rider_id FK "🟢 มอบหมายชัดเจน"
        string proof_image
        string status
    }
    SETTINGS {
        string key PK "🟢 vat_rate ฯลฯ"
        string value
    }
```

---

## 13. UI/UX ที่เสนอ (To-Be Frontend)

```mermaid
graph TB
    subgraph layout["🟢 Layout เดียว (app.blade.php)"]
        nav["Navigation คงที่ทุกหน้า"]
        subgraph comp["🟢 Blade Components (reuse)"]
            table["x-data-table<br/>(ค้นหา + sort + pagination)"]
            card["x-stat-card"]
            modal["x-modal"]
        end
    end
    scss["🟢 CSS รวมใน app.scss<br/>(เลิกฝัง style ในแต่ละหน้า)"]

    layout --> pages["ทุกหน้าใช้ layout + component เดียวกัน"]
    scss --> pages
    pages --> result["หน้าตาสม่ำเสมอ<br/>รองรับข้อมูลจำนวนมาก"]
```

**สิ่งที่ต้องมีในทุกหน้ารายการ (🟢 แก้จาก As-Is):**
- **Pagination** — `->paginate(20)` + `{{ $items->links() }}` ทุกหน้า
- **ค้นหา / กรอง / เรียงลำดับ** เป็นมาตรฐาน
- **Layout เดียว** + Blade component ที่ reuse ได้
- CSS รวมศูนย์ใน `app.scss`

---

## 14. สรุปเปรียบเทียบ As-Is ↔ To-Be (สไลด์เสนอน้องๆ)

| หัวข้อ | As-Is (ปัจจุบัน 🔴) | To-Be (ที่เสนอ 🟢) |
|--------|---------------------|---------------------|
| **ความปลอดภัย** | POS เปิดโล่งไม่ต้อง login | login + Policy/Gate ทุก role |
| **ความถูกต้องข้อมูล** | ไม่มี transaction, สต็อกพังได้ | DB transaction + lockForUpdate |
| **Validation** | มีบ้างไม่มีบ้าง | Form Request ทุก endpoint |
| **สถาปัตยกรรม** | logic ยัดใน controller | Service layer แยกชัด |
| **กฎธุรกิจ (VAT/ราคา)** | hardcode ในโค้ด | เก็บใน settings |
| **Pagination** | ไม่มีเลย | ทุกหน้ารายการ |
| **UI/Layout** | 4 layout ตีกัน, ไม่ reuse | layout เดียว + component |
| **Order status** | ปนกันในโค้ด | state machine ชัดเจน |
| **เอกสาร/เทส** | ไม่มี | requirement + unit test |

---

## 15. แผนดำเนินการที่เสนอ (Roadmap เสนอน้องๆ)

```mermaid
flowchart LR
    p1["Phase 1<br/>🔴 ความปลอดภัย<br/>auth ทุก route<br/>+ transaction checkout"] --> p2["Phase 2<br/>Pagination +<br/>รวม Layout"]
    p2 --> p3["Phase 3<br/>Service layer +<br/>Form Request"]
    p3 --> p4["Phase 4<br/>Blade component +<br/>UI สม่ำเสมอ"]
    p4 --> p5["Phase 5<br/>เขียน Test +<br/>ปรับ ERD"]
```

> **ลำดับความสำคัญ:** Phase 1 (ความปลอดภัย + ความถูกต้องข้อมูล) ต้องทำก่อนเสมอ
> เพราะเป็นเรื่องที่ทำให้ "ระบบเงิน/สต็อกเชื่อถือได้" — ที่เหลือคือยกระดับคุณภาพและประสบการณ์ใช้งาน

---
---

# 16. Activity Diagram ระดับธุรกิจ (Business Activity)

> ส่วนนี้อธิบาย **กระบวนการทำงานจริงของร้าน** ว่าใครทำอะไร ก่อน-หลังอย่างไร
> เขียนในภาษาธุรกิจล้วน ๆ (ไม่พูดถึงหน้าจอ ฐานข้อมูล หรือวิธีเขียนโปรแกรม)
> เพื่อใช้ยืนยันกับเจ้าของร้านว่า "เข้าใจงานตรงกัน" ก่อนจะออกแบบระบบ

| # | กระบวนการ | ผู้เกี่ยวข้อง | ไฟล์แยก |
|---|-----------|-------------|---------|
| B-1 | ขายหน้าร้าน | ลูกค้า, พนักงานขาย | `mermaid/04-activity-sale.mmd` |
| B-2 | จัดส่งสินค้า | เจ้าของร้าน, พนักงานส่งของ, ลูกค้า | `mermaid/05-activity-delivery.mmd` |
| B-3 | รับสินค้าเข้าร้าน | ผู้ขายส่ง, เจ้าของร้าน | `mermaid/06-activity-stock-in.mmd` |
| B-4 | ยกเลิกรายการขาย & คืนเงิน | ลูกค้า, พนักงานขาย, เจ้าของร้าน | `mermaid/07-activity-cancel-refund.mmd` |

ภาพรวมทั้งกระบวนการรวมอยู่ในไฟล์เดียวที่ `bpmn/business-process-sale-and-delivery.bpmn`

---

## B-1 — ขายหน้าร้าน

**เริ่มเมื่อ:** ลูกค้าเข้ามาถามซื้อสินค้า
**เงื่อนไขก่อนเริ่ม:** ร้านมีข้อมูลสินค้าและราคาที่ตั้งไว้แล้ว
**ผลลัพธ์ที่ต้องได้:** ลูกค้าได้สินค้าหรือได้นัดส่ง, ร้านได้เงิน, มีใบเสร็จ และจำนวนสินค้าคงเหลือลดลงตามที่ขายจริง
**กรณียกเว้น:** สินค้าไม่พอ → เสนอทางเลือกหรือจบโดยไม่เกิดการซื้อขาย

```mermaid
flowchart TD
    subgraph C["👤 ลูกค้า"]
        S([ลูกค้าต้องการซื้อสินค้า]) --> C1["แจ้งรายการสินค้าที่ต้องการ"]
        C2{"รับข้อเสนอทางเลือกไหม?"}
        C3([ไม่เกิดการซื้อขาย])
        C4["ชำระเงิน"]
        C5["รับสินค้าที่ร้าน"]
        C6([ปิดการขาย])
        C7([รอรับของที่บ้าน])
    end

    subgraph E["👤 พนักงานขาย"]
        E1["ตรวจสอบสินค้าและจำนวนคงเหลือ"]
        E2{"มีสินค้าพอขายไหม?"}
        E3["เสนอทางเลือก<br/>สั่งเพิ่ม / สินค้าทดแทน"]
        E4["บันทึกรายการขาย"]
        E5["ระบุประเภทลูกค้า<br/>ทั่วไป / ร้านค้า / ช่าง"]
        E6["คิดราคาตามประเภทลูกค้า<br/>ปลีกหรือส่ง + ภาษีมูลค่าเพิ่ม"]
        E7["แจ้งยอดรวมที่ต้องชำระ"]
        E8["ออกใบเสร็จ<br/>และตัดจำนวนสินค้าคงเหลือ"]
        E9{"ลูกค้ารับเองหรือให้จัดส่ง?"}
        E10["ส่งต่อให้งานจัดส่ง"]
    end

    C1 --> E1
    E1 --> E2
    E2 -->|"ไม่พอ"| E3
    E3 --> C2
    C2 -->|"ไม่รับ"| C3
    C2 -->|"รับข้อเสนอ"| C1
    E2 -->|"พอขาย"| E4
    E4 --> E5
    E5 --> E6
    E6 --> E7
    E7 --> C4
    C4 --> E8
    E8 --> E9
    E9 -->|"รับเองที่ร้าน"| C5
    C5 --> C6
    E9 -->|"ให้จัดส่ง"| E10
    E10 --> C7
```

---

## B-2 — จัดส่งสินค้า

**เริ่มเมื่อ:** ลูกค้าชำระเงินแล้วและขอให้จัดส่ง
**เงื่อนไขก่อนเริ่ม:** มีพนักงานส่งของที่ว่างรับงาน
**ผลลัพธ์ที่ต้องได้:** ลูกค้าได้รับของ มีหลักฐานการส่งที่เจ้าของร้านตรวจแล้ว และรายการขายถูกปิด
**กรณียกเว้น:** ส่งไม่สำเร็จ → นัดส่งใหม่ หรือยกเลิกและคืนเงิน (ไปต่อ B-4)

```mermaid
flowchart TD
    subgraph O["👤 เจ้าของร้าน / ผู้จัดการ"]
        S([มีรายการขายที่ต้องจัดส่ง]) --> O1["ดูรายการที่รอจัดส่ง"]
        O1 --> O2["มอบหมายงานให้พนักงานส่งของ<br/>ระบุวันและรอบที่จะส่ง"]
        O3{"นัดส่งใหม่ไหม?"}
        O4["ตรวจหลักฐานการส่ง"]
        O5{"หลักฐานครบถ้วนไหม?"}
        O6["แจ้งให้ส่งหลักฐานเพิ่ม"]
        O7["ปิดงานจัดส่ง"]
        O8([ปิดการขาย])
        O9["ยกเลิกรายการขาย<br/>คืนของเข้าร้าน + คืนเงินลูกค้า"]
        O10([ยกเลิกและคืนเงิน])
    end

    subgraph R["👤 พนักงานส่งของ"]
        R1["ดูงานส่งของตัวเอง"]
        R2["รับงานและรับของออกจากร้าน"]
        R3["นำสินค้าไปส่งลูกค้า"]
        R4{"ส่งสำเร็จไหม?"}
        R5["แจ้งเหตุผลที่ส่งไม่สำเร็จ"]
        R6["บันทึกหลักฐานการส่ง<br/>รูปถ่าย / ลายเซ็นลูกค้า"]
        R7["ส่งหลักฐานเพิ่มเติม"]
    end

    subgraph C["👤 ลูกค้า"]
        C1["ตรวจรับสินค้า + เซ็นรับ"]
    end

    O2 --> R1
    R1 --> R2
    R2 --> R3
    R3 --> R4
    R4 -->|"ไม่สำเร็จ"| R5
    R5 --> O3
    O3 -->|"นัดส่งใหม่"| O2
    O3 -->|"ไม่นัดแล้ว"| O9
    O9 --> O10
    R4 -->|"สำเร็จ"| C1
    C1 --> R6
    R6 --> O4
    O4 --> O5
    O5 -->|"ไม่ครบ"| O6
    O6 --> R7
    R7 --> O4
    O5 -->|"ครบถ้วน"| O7
    O7 --> O8
```

---

## B-3 — รับสินค้าเข้าร้าน

**เริ่มเมื่อ:** ผู้ขายส่งนำสินค้ามาส่งที่ร้านพร้อมใบส่งของ
**เงื่อนไขก่อนเริ่ม:** มีคำสั่งซื้อหรือข้อตกลงกับผู้ขายส่งไว้แล้ว
**ผลลัพธ์ที่ต้องได้:** จำนวนคงเหลือในระบบตรงกับของจริงในร้าน และรู้ต้นทุนของล็อตนั้น
**กรณียกเว้น:** ของขาด / ของเสีย → แจ้งผู้ขายส่งและรับเข้าเฉพาะจำนวนที่รับจริง

```mermaid
flowchart TD
    subgraph SUP["🏭 ผู้ขายส่ง (Supplier)"]
        S([ส่งสินค้าพร้อมใบส่งของมาที่ร้าน])
        SUP1["รับสินค้าที่ไม่ตรงกลับไป<br/>/ ส่งของชดเชย"]
    end

    subgraph O["👤 เจ้าของร้าน / ผู้จัดการ"]
        O1["ตรวจนับสินค้าเทียบกับใบส่งของ"]
        O2{"ของตรงกับใบส่งของไหม?"}
        O3["แจ้งผู้ขายส่งเรื่องของขาด / ของเสีย"]
        O4["บันทึกจำนวนที่รับจริง<br/>+ ต้นทุนต่อหน่วย + เลขล็อต"]
        O5{"เป็นสินค้าใหม่ที่ยังไม่เคยขายไหม?"}
        O6["เพิ่มรายการสินค้าใหม่<br/>ระบุหมวด ยี่ห้อ หน่วยนับ"]
        O7["ตั้งราคาปลีก / ราคาส่ง"]
        O8["ยืนยันรับเข้าสต็อก<br/>จำนวนคงเหลือเพิ่มขึ้น"]
        O9["เก็บใบส่งของไว้กระทบยอดกับบิลผู้ขายส่ง"]
        O10([สินค้าพร้อมขาย])
    end

    S --> O1
    O1 --> O2
    O2 -->|"ไม่ตรง"| O3
    O3 --> SUP1
    SUP1 --> O1
    O2 -->|"ตรง"| O4
    O4 --> O5
    O5 -->|"ใช่"| O6
    O6 --> O7
    O7 --> O8
    O5 -->|"ไม่ใช่"| O8
    O8 --> O9
    O9 --> O10
```

---

## B-4 — ยกเลิกรายการขาย & คืนเงิน

**เริ่มเมื่อ:** ลูกค้าขอยกเลิกหรือคืนสินค้า / ส่งไม่สำเร็จและไม่นัดส่งใหม่
**เงื่อนไขก่อนเริ่ม:** ยังไม่ปิดการขาย หรือสินค้ามีปัญหาตามเงื่อนไขที่ร้านกำหนด
**ผลลัพธ์ที่ต้องได้:** ลูกค้าได้เงินคืน สินค้ากลับเข้าสต็อก และยอดขายถูกตัดออกจากรายงาน
**กรณียกเว้น:** ไม่เข้าเงื่อนไข → เสนอทางเลือกอื่นแทน เช่น เปลี่ยนสินค้า

```mermaid
flowchart TD
    subgraph C["👤 ลูกค้า"]
        S([ลูกค้าขอยกเลิก / คืนสินค้า]) --> C1["แจ้งเหตุผลและแสดงใบเสร็จ"]
        C2["รับเงินคืน / รับใบลดหนี้"]
        C3([จบ — ยกเลิกสำเร็จ])
        C4([จบ — ไม่ยกเลิก])
    end

    subgraph E["👤 พนักงานขาย"]
        E1["ค้นหารายการขายจากใบเสร็จ"]
        E2["แจ้งลูกค้าว่ายกเลิกไม่ได้<br/>เสนอทางเลือกอื่น เช่น เปลี่ยนสินค้า"]
        E3["คืนสินค้าเข้าสต็อก<br/>+ ระบุสภาพของที่รับคืน"]
        E4["คืนเงินตามช่องทางที่ลูกค้าชำระ"]
    end

    subgraph O["👤 เจ้าของร้าน / ผู้จัดการ"]
        O1{"อยู่ในเงื่อนไขที่ยกเลิกได้ไหม?<br/>ยังไม่ส่ง / ส่งไม่สำเร็จ / ของมีปัญหา"}
        O2["อนุมัติการยกเลิก + บันทึกเหตุผล"]
        O3["ตัดยอดขายออกจากรายงาน"]
    end

    C1 --> E1
    E1 --> O1
    O1 -->|"ไม่เข้าเงื่อนไข"| E2
    E2 --> C4
    O1 -->|"เข้าเงื่อนไข"| O2
    O2 --> E3
    E3 --> E4
    E4 --> C2
    C2 --> O3
    O3 --> C3
```

---

# 17. กฎธุรกิจที่ต้องตกลงให้ชัด

กฎพวกนี้คือสิ่งที่ต้องถามเจ้าของร้านให้ได้คำตอบ ก่อนเริ่มออกแบบระบบ

## 17.1 การคิดราคา

```mermaid
flowchart TD
    S([เริ่มคิดราคาให้ลูกค้า]) --> A{"ระบุตัวตนลูกค้าได้ไหม?"}
    A -->|"ลูกค้าเดินเข้าร้านทั่วไป"| R["ใช้ราคาปลีก"]
    A -->|"เป็นลูกค้าที่มีประวัติในร้าน"| B{"ประเภทลูกค้า?"}
    B -->|"ทั่วไป"| R
    B -->|"ร้านค้า / ช่าง"| C{"ซื้อถึงจำนวนขั้นต่ำ<br/>ที่กำหนดสำหรับราคาส่งไหม?"}
    C -->|"ไม่ถึง"| R
    C -->|"ถึง"| W["ใช้ราคาส่ง"]
    R --> V["บวกภาษีมูลค่าเพิ่มตามอัตราที่ร้านตั้งไว้"]
    W --> V
    V --> D{"มีส่วนลดพิเศษที่เจ้าของร้านอนุมัติไหม?"}
    D -->|"มี"| E["หักส่วนลด + บันทึกผู้อนุมัติ"]
    D -->|"ไม่มี"| F["ยอดสุทธิที่ต้องชำระ"]
    E --> F
    F --> Z([แจ้งยอดให้ลูกค้า])
```

| รหัส | กฎ | สิ่งที่ต้องเคาะให้ชัด |
|------|-----|---------------------|
| BR-01 | ใครได้ราคาส่ง | ลูกค้าประเภทไหนบ้าง และต้องซื้อขั้นต่ำเท่าไรถึงได้ราคาส่ง |
| BR-02 | ภาษีมูลค่าเพิ่ม | อัตราปัจจุบันเท่าไร และถ้าเปลี่ยนต้องแก้ได้เองโดยไม่ต้องแก้โปรแกรม |
| BR-03 | ส่วนลดพิเศษ | ใครอนุมัติได้ ลดได้สูงสุดเท่าไร ต้องบันทึกผู้อนุมัติไหม |
| BR-04 | ขายเกินจำนวนที่มี | ถ้าของไม่พอ อนุญาตให้รับออเดอร์ค้างส่งไหม หรือห้ามขายเด็ดขาด |

## 17.2 การขายและการส่งมอบ

| รหัส | กฎ | สิ่งที่ต้องเคาะให้ชัด |
|------|-----|---------------------|
| BR-05 | ค่าจัดส่ง | คิดตามระยะทาง / ยอดซื้อ / ฟรีเมื่อถึงยอดเท่าไร |
| BR-06 | หลักฐานการส่ง | ต้องมีอะไรบ้างถึงถือว่าส่งครบ (รูปสินค้า, ลายเซ็น, ชื่อผู้รับ) |
| BR-07 | ส่งไม่สำเร็จ | นัดใหม่ได้กี่ครั้ง ก่อนจะถือว่ายกเลิก |
| BR-08 | ปิดการขาย | ใครเป็นคนปิด และปิดแล้วแก้ไขย้อนหลังได้หรือไม่ |

## 17.3 การยกเลิกและคืนสินค้า

| รหัส | กฎ | สิ่งที่ต้องเคาะให้ชัด |
|------|-----|---------------------|
| BR-09 | ช่วงเวลาที่ยกเลิกได้ | ยกเลิกได้ถึงขั้นตอนไหน หลังรับของแล้วคืนได้กี่วัน |
| BR-10 | สภาพสินค้าที่รับคืน | ของที่ตัดแล้ว / ของสั่งพิเศษ รับคืนไหม |
| BR-11 | วิธีคืนเงิน | คืนเป็นเงินสด / โอน / เครดิตไว้ซื้อครั้งหน้า |
| BR-12 | ผู้มีอำนาจอนุมัติ | พนักงานขายอนุมัติเองได้ไหม หรือต้องเจ้าของร้านเท่านั้น |

## 17.4 ลูกค้าและสินค้าคงคลัง

| รหัส | กฎ | สิ่งที่ต้องเคาะให้ชัด |
|------|-----|---------------------|
| BR-13 | การระบุตัวลูกค้า | ใช้อะไรเป็นตัวระบุ และลูกค้าคนเดิมที่เปลี่ยนเบอร์ต้องยังเป็นคนเดิม |
| BR-14 | แต้มสะสม / เครดิตร้านค้า | มีไหม คิดอย่างไร ใช้ได้กับอะไรบ้าง |
| BR-15 | การตรวจนับสต็อก | นับจริงถี่แค่ไหน และถ้าไม่ตรงกับระบบใช้ตัวไหนเป็นหลัก |
| BR-16 | จุดสั่งซื้อเพิ่ม | เหลือเท่าไรถึงต้องเตือนให้สั่งของเข้าร้าน |
