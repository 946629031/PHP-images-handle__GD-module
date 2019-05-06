<?php



 
// /*打开图片*/
// //1.配置图片路径
// $src = "bg.jpg";
// //2.获取图片信息
// $info = getimagesize($src);
// //3.通过编号获取图像类型
// $type = image_type_to_extension($info[2],false);
// //4.在内存中创建和图像类型一样的图像
// $fun = "imagecreatefrom".$type;
// //5.图片复制到内存
// $image = $fun($src);
// // var_dump($fun);exit;
 
// /*操作图片*/
// //1.设置字体的路径
// $font = "PingFang_Medium.ttf";
// //2.填写水印内容
// $content = "some special words are supported.";
// //3.设置字体颜色和透明度
// $color = imagecolorallocatealpha($image, 255, 255, 255, 0);
// //4.写入文字
// imagettftext($image, 20, 0, 10, 10, $color, $font, $content);
// /*输出图片*/
// //浏览器输出
// header("Content-type:".$info['mime']);
// $fun = "image".$type;
// $fun($image);
// //保存图片
// $fun($image,'bg_res.'.$type);
// /*销毁图片*/
// imagedestroy($image);







// PPI = (72*像素数)/磅值
// PPI*磅值 = 72*像素数
// 20px = 14.5磅
// 磅值 = 72*像素数/PPI
// 磅值 = 72*20/90

// (10.5/72)*96=14px
// 像素数 = 磅值/72*96
// 磅值 = 像素数/72*96

// (磅值/72)*96 = 像素数
// (24/72)*96=32px
// 磅值 = 像素数*72/96
// 839*72/96 = 201.4 ?


// pt=px*72/dpi 
// pt=px*72/1.100000023841858


// header('Content-Type: image/png');
header('content-type:text/html;charset=utf-8');
// var_dump(gd_info());exit;



// 创建连接数据库
//               ($servername, $username, $password, $dbname);
$conn = new mysqli("localhost", "root", '', "threeki");
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 

// $sql = "INSERT INTO xx2 (`id`, `name`, `img`, `main_address`, `other_address`) VALUES ".implode(',',$valueStr);
// if ($conn->query($sql) === TRUE) {
//     echo "新记录插入成功";
// } else {
//     echo "Error: " . $conn->error;
// }

$sql = "SELECT id, `number`, `name`, `deparment`, `title` FROM xx";
$result = $conn ->query($sql);

$all_menbers = array();
if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()){
        // echo "id: " . $row["id"]. " - number: " . $row["number"]. " - Name: " . $row["name"]. " - deparment: " . $row["deparment"]. " - title: " . $row["title"]. "<br>";
        $all_menbers[] = $row;
    }
}else{
    echo '0结果';
}

$conn->close();
// var_dump($all_menbers);
// exit;



// $number = 'No.T0042';
// $name = '齐虹';
// $deparment = '职能部';
// $title = '销售经理&咨询经理';
// $menber = array('T0118','伍朱琳','推广部','网站编辑');

// //将值拆分为数组
// $number = str_split($number,1);
// $name = str_split($name,3);
// $title = array('人','事','主','管','&','客','服','主','管');
// $deparment = str_split($deparment,3);


// var_dump(count($all_menbers));exit;

foreach($all_menbers as $key => $v){
    $number = 'No.'.$v['number'];
    $name = $v['name'];
    $title = $v['title'];
    $deparment = $v['deparment'];

    $number = str_split($number,1);
    $name = str_split($name,3);
    $title = str_split($title,3);
    $deparment = str_split($deparment,3);
    

    $img = "bg2.jpg";//图片跟路径
    // $name = array('伍','朱','琳');//将值拆分为数组
    $font = __DIR__."/p.ttf";//加载字体ttf
    $img = imagecreatefromjpeg($img);// 加载已有图像
    $aa=getimagesize("bg.jpg");
    $weight=$aa["0"];////获取图片的宽
    $height=$aa["1"];///获取图片的高
    // var_dump($weight, $height);exit;


    // 写入员工号
    $size = 37*72/96;//字体大小
    $black = imagecolorallocate($img, 102, 102, 102);//设置颜色为蓝色
    $x =325;//首个字的横坐标
    // $x = ($weight - count($number)*37)/2;//首个字的横坐标
    foreach ($number as $k=>$v){
        imagettftext($img, $size, 0, $x, 1105, $black, $font, $v);//循环添加文字
        $x = $x + 23;//增加横坐标来做到间距的效果
    }


    // 写入名字
    $size = 80*72/96;//字体大小
    $black = imagecolorallocate($img, 221, 36, 74);//设置颜色为蓝色
    // $x =300;//首个字的横坐标
    // $x = ($weight - count($name)*$size - (count($name)-1)*84)/2;
    // $x = ($weight*72/96 - count($name)*$size - (count($name)-1)*84);
    $x = ($weight - count($name)*80)/2;
    foreach ($name as $k=>$v){
        imagettftext($img, $size, 0, $x, 865, $black, $font, $v);//循环添加文字
        $x = $x + 84;//增加横坐标来做到间距的效果
    }


    // 写入职位
    $size = 42*72/96;//字体大小
    $black = imagecolorallocate($img, 102, 102, 102);//设置颜色为蓝色
    // $x =300;//首个字的横坐标
    $x = ($weight - count($title)*42)/2;//首个字的横坐标
    foreach ($title as $k=>$v){
        imagettftext($img, $size, 0, $x, 970, $black, $font, $v);//循环添加文字
        $x = $x + 41;//增加横坐标来做到间距的效果
    }


    // 写入部门
    $size = 37*72/96;//字体大小
    $black = imagecolorallocate($img, 102, 102, 102);//设置颜色为蓝色
    // $x =325;//首个字的横坐标
    $x = ($weight - count($deparment)*37)/2;//首个字的横坐标
    // $x = $x*72/96;
    foreach ($deparment as $k=>$v){
        imagettftext($img, $size, 0, $x, 1040, $black, $font, $v);//循环添加文字
        $x = $x + 36;//增加横坐标来做到间距的效果
    }


    // $time = rand(1,10000).time().".png";//定义图片名
    ImagePNG($img, $key.".png");//保存图片
    // ImagePNG($img);//保存图片,结果输出到浏览器

    // $time = rand(1,10000).time().".png";//定义图片名
    // ImagePNG($img,__DIR__."/".$time);//保存图片
}