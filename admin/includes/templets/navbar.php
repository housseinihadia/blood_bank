

<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">الرئيسيه</a>
    </div>

   
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
د        <li><a href='items.php'>طلبات الدم </a></li>
        <li><a href="comments.php">  التعليقات</a></li>
        <li><a href="members.php">الاعضاء </a></li>
      </ul>
    
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">المدير المسؤل <span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li><a href="../index.php">زياره الموقع</a></li>
            <li><a href="members.php?do=edit&userid=<?php echo $_SESSION['id'] ?>">اعديل الاعضاء</a></li>
             <li><a href="#">الاعدادات</a></li>
            <li><a href="logout.php">تسجيل خروج</a></li>
          </ul>
        </li>
      </ul>
    </div>
</nav>