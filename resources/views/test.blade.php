<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>test</title>
    <style>
        .form-control{
            max-width: 35;
            width: 20;
            color: blue;
        }

    </style>
</head>
<body>
    @extends('layouts.sidebar')

</body>
<div class="col py-3 main-content">
    <div class="form-control">
    {{-- <form>
        <h3>รายการเครื่องดื่ม</h3> --}}
        <label for="coffeelist">กรอกเครื่องดื่มที่ต้องการ</label>
        <input type="" class="mb-3 col-md-4" id="coffeelist" placeholder="เช่น อเมริกาโน่">
    {{-- </form> --}}
    <input type="submit" class="btn btn-primary" value="submit" onclick="myConfirmFunction()">

    <script>

function myConfirmFunction() {
    if (confirm("คุณต้องการบันทึกข้อมูลใช่ไหม?")) {
        alert("บันทึกข้อมูลแล้ว");
    } else {
        alert("ยกเลิกการบันทึก");
    }
}
    </script>



</div>
</div>












</html>
