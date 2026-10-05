<?php
$conn = new mysqli("localhost", "root", "", "school_db");

// فحص الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// استقبال البيانات المبعوثة من النموذج
$name      = $_POST['name'];
$email     = $_POST['email'];
$password  = password_hash($_POST['password'], PASSWORD_DEFAULT);
$user_type = $_POST['user_type'];

// تحديد الجدول المطلوب (teachers أو students)
if ($user_type == 'teacher') {
    $table = "teachers";
} else {
    $table = "students";
}

// تنفيذ استعلام الإضافة المباشر
$sql = "INSERT INTO $table (name, email, password) VALUES ('$name', '$email', '$password')";
if ($conn->query($sql) === TRUE) {
    // التوجيه إلى صفحة welcome.html ونقل الاسم ونوع الحساب في الرابط
    $name_encoded = urlencode($name);
    $type_encoded = urlencode($user_type);
    header("Location: welcome.html?name=$name_encoded&type=$type_encoded");
    exit();
} else {
    echo "<h2>حدث خطأ:</h2> " . $conn->error;
}

$conn->close();
?>