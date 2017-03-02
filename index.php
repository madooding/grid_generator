<?php
if(!($_POST["width"]>0 && $_POST["margin"]>=0 && $_POST["gutter"]>=0 && $_POST["column"]>0)){
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Grid not Krit - grid.madooding.com</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="https://files.madooding.com/bootstrap-v3.2.2/css/bootstrap.min.css" >
<link rel="stylesheet" href="./css/grid.css">
<script type="text/javascript" src="https://files.madooding.com/temp/jquery-2.0.3.min.js"></script>
<script>
$(function(){
	$(window).on('resize', setheight);
	setheight();
	
	$('#generate').on('click', function(event){
		width = document.getElementById('width').value;
		column = document.getElementById('column').value;
		if(width == 0 || column ==0){
				$('#error').removeClass('disappear');
				event.preventDefault();
			}else{
				$('#error').addClass('disappear');
			}
		res = document.getElementById('width').value;
		if(res <= 0 || res == ''){
			res = 72;
		}
		});
	});
function setheight(){
	var win = $(window).height();
	var padding= (win - ($('#main').height()+10)) / 2.0;
	$('#main').css({'padding-top':padding+'px'});
	
}
</script>
</head>
<body>
	<div class="main container-fluid" id="main">
    	<div class="row" style="margin:10px 0px 10px 0px;">
            <div class="row">
                <div class=" col-lg-12"><h1 id="hlabel">Grid</h1></div>
            </div>
            <div class="row">
                <div class="col-lg-12"><h3 id="slabel">&nbsp;not Krit</h3></div>
            </div>
        </div>
        <div class="row disappear" id="error">
        	<div class="col-lg-12" style="vertical-align:middle"><div class="alert alert-warning" role="alert"><strong>Warning :</strong> to generate the grid, width and column values musn't be zero.</div></div>
        </div>
        <form action="#" method="post">
        <div class="row">
        	<div class="form-group">
                <div class="col-lg-6 col-md-6 col-sm-6">
                <label for="exampleInputEmail1">&nbsp;Width</label>
                    <div class="input-group">                    	
                    	<input type="text" class="form-control input-lg" placeholder="0" id="width" name="width" autofocus>
                        <div class="input-group-addon"><b>Px</b></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                <label for="exampleInputEmail1">&nbsp;Column</label>
                    <div class="input-group">
                    	<input type="text" class="form-control input-lg" id="column" placeholder="12" name="column" value="12">
                        <div class="input-group-addon"><b>Column</b></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-lg-6 col-md-6 col-sm-6">
            <label for="exampleInputEmail1">&nbsp;Margin</label>
                <div class="input-group">
                    <input type="text" class="form-control input-lg" id="margin" name="margin" placeholder="0">
                    <div class="input-group-addon"><b>Px</b></div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
            <label for="exampleInputEmail1">&nbsp;Gutter</label>
                <div class="input-group">
                    <input type="text" class="form-control input-lg" id="gutter" name="gutter" placeholder="0">
                    <div class="input-group-addon"><b>Px</b></div>
                </div>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-lg-12 col-md-12 col-sm-12">
            <label for="exampleInputEmail1">&nbsp;Resolution</label>
                <div class="input-group">
                    <input type="text" class="form-control input-lg" id="res" name="res" placeholder="72" value="72">
                    <div class="input-group-addon"><b>Px/inch</b></div>
                </div>
            </div>
        </div>
        
        <div class="row" style="margin:30px 0px 10px 0px;">
        	<div class="col-lg-4 col-lg-offset-2  col-md-4 col-md-offset-2  col-sm-6"><button type="submit" class="btn btn-primary btn-lg col-lg-12 col-md-12  col-sm-12" id="generate">Generate!</button>
            </div>
            <div class="col-lg-4  col-md-4 col-sm-6"><button type="reset" class="btn btn-default btn-lg col-lg-12 col-md-12 col-sm-12">Clear</button>
            </div>
        </div>
        </form>
    	<div class="row" style="margin-top:30px"><div class="col-lg-12"><p class="text-center"><strong> Developed by <a href="https://fb.com/madooding">@madooding </a></strong></p></div></div>
    </div>
</body>
</html>
<?php
}else{	
	$fp=fopen("count.txt","r");
	$gencount=fread($fp,10000);
	$fp=fopen("count.txt","w");
	fwrite($fp,$gencount+1);
	fclose($fp);

	$column=$_POST["column"];
	$margin=$_POST["margin"];
	$gutter=$_POST["gutter"];
	$width=$_POST["width"];
    $resulotion=($_POST["res"]==0 || $_POST["res"]=='')? 72:$_POST["res"];
    $width=($width*72)/$resulotion;
    $margin=($margin*72)/$resulotion;
    $gutter=($gutter*72)/$resulotion;
	$block=($width-(($margin*2)+($gutter*($column-1))))/$column;
	$count=1;
	$stat=0;
	$columncount=1;
	while($stat<$width){
		if($count==1){
			$arr[$count]=$margin;
			$stat+=$margin;
			$count++;
		}
		if($columncount<$column){
			$columncount++;
		$stat+=$block;
		$arr[$count]=$stat;
		$stat+=$gutter;
		$arr[$count+1]=$stat;
		$count+=2;
	}else{
		$stat+=$block;
		$arr[$count]=$stat;
		$columncount++;
		break;
	}
	}
	$text="var gridGuides = [";
	foreach ($arr as $key => $value) {
		if($key==1){
			$text.=$value;

		}else{
		$text.=",".$value;
	}
	}
	$text.="];";
header('Content-Type: text/plain; charset=UTF-8');
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="makeGrid.jsx"'); //<<< Note the " " surrounding the file name
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
echo "//Number : ".$gencount;
?>

//Programmer : @madooding
//Facebook : facebook.com/madooding
//Twitter : twitter.com/madooding
//I hope it will be useful !
#target photoshop
app.bringToFront();
<?php
echo $text;
?>

var newDocGutter = 0;
var gridMin = Math.min.apply(null, gridGuides);
var gridMax = Math.max.apply(null, gridGuides);


makeGrid();

/* function loops through the array holdin the grid guides */
function makeGrid() {
    for(i=0; i < gridGuides.length; i++) {
        makeGuide(gridGuides[i],"Vrtc");
    }
}

// function found on Adobe's blog post: http://blogs.adobe.com/crawlspace/2006/05/installing_and_1.html
function makeGuide(pixelOffSet, orientation) {
    var id8 = charIDToTypeID( "Mk  " );
    var desc4 = new ActionDescriptor();
    var id9 = charIDToTypeID( "Nw  " );
    var desc5 = new ActionDescriptor();
    var id10 = charIDToTypeID( "Pstn" );
    var id11 = charIDToTypeID( "#Rlt" );
    desc5.putUnitDouble( id10, id11, pixelOffSet ); // integer
    var id12 = charIDToTypeID( "Ornt" );
    var id13 = charIDToTypeID( "Ornt" );
    var id14 = charIDToTypeID( orientation ); // "Vrtc", "Hrzn"
    desc5.putEnumerated( id12, id13, id14 );
    var id15 = charIDToTypeID( "Gd  " );
    desc4.putObject( id9, id15, desc5 );
    executeAction( id8, desc4, DialogModes.NO );
}
<?php
unset($_POST["gen"]);
}
?>