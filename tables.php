<?php

require_once('DbConect.php');

$parftTable = " create table parfts(
 pno integer(5) not null,
 pname varchar(30),
 qoh integer,
 price decimal(6,2),
 olevel integer,
 primary key (pno))";
mysqli_query($con, $parftTable);
$add1="INSERT INTO parfts (pno,pname,qoh,price,olevel) values('1', 'r','1','100','1')";
mysqli_query($con, $add1);
$add2="INSERT INTO parfts (pno,pname,qoh,price,olevel) values('2', 'raa','2','200','2')";
mysqli_query($con, $add2);
$add3="INSERT INTO parfts (pno,pname,qoh,price,olevel) values('3', 'raazz','3','300','3')";
mysqli_query($con, $add3);

$customerTable = "create table customers (
 cno integer(10) not null auto_increment ,
 cname varchar(30),
 street varchar(50),
 city varchar(30),
 state varchar(30),
 zip integer(5),
 phone char(12),
 email varchar(50),
 password varchar(15),
 primary key (cno)) ";
mysqli_query($con, $customerTable);
$qucu1 = " INSERT INTO customers (cname,street,city,state,zip,phone,email,password) values('Razan','naser','gaza','1','111','1234','r@gmail,'123456')";
$resul1 = mysqli_query($con, $qucu1);
$qucu2 = " INSERT INTO customers (cname,street,city,state,zip,phone,email,password) values('sara','remal','gaza','1','111','1234','s@gmail,'123456')";
$resul2 = mysqli_query($con, $qucu2);
$qucu3 = " INSERT INTO customers (cname,street,city,state,zip,phone,email,password) values('shimaa','rafah','gaza','1','111','1234','sh@gmail,'123456')";
$resul3 = mysqli_query($con, $qucu3);

$cartTable = " create table cart(
 cartno integer(10) not null auto_increment,
 cno integer(10) not null references customers(cno) ,
 pno integer(5) not null references parts(pno),
 qty integer,
 primary key (cartno, pno)
 )";
mysqli_query($con, $cartTable);
if(isset($_SESSION['cno'])){
    $cno = $_SESSION['cno'];
}
//$quOr1 = " INSERT INTO cart (cno,pno,qty) values('$cno', '1','3')";
//$result1 = mysqli_query($con, $quOr1);
//$quOr2 = " INSERT INTO cart (cno,pno,qty) values('$cno', '2','5')";
//$result2 = mysqli_query($con, $quOr2);
//$quOr3 = " INSERT INTO cart (cno,pno,qty) values('$cno', '3','6')";
//$result3 = mysqli_query($con, $quOr3);

$orderTable = "create table orders (
 ono integer(5) not null auto_increment ,
 cno integer(10) references customers(cno),
 received date,
 shipped date,
 primary key (ono)
  ) ";
mysqli_query($con, $orderTable);


$detailsTable = "create table odetails (
 ono integer(5) not null references orders(ono),
 pno integer(5) not null references parts(pno),
 qty integer,
 primary key (ono,pno)
) ";
mysqli_query($con, $detailsTable);



