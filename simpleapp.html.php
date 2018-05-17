<html>
<head>
    <link rel="stylesheet" href="simpleapp.css" type="text/css">

</head>
<body>
<form class="form" action="sendAndCompare.php">
    <div class="info_container">
        <div class="item"><span>Total characters: </span><span id="sym_num"></span></div>
    </div>
    <div class="form_container">
        <label><input type="text" id="link1" name="link1" placeholder="Domain 1" value="<?=$link1?>"><span>Sum: </span><span id="sum1"></span></label>
        <label><input type="text" id="link2" name="link2" placeholder="Domain 2" value="<?=$link2?>"><span>Sum: </span><span id="sum2"></span></label>
        <input type="submit" class="button" value="Compare and show">
        <input type="submit" name="download" class="button" value="Compare and download CSV">

    </div>
    <div class="output">
        <?php if($output): ?>
            <?php foreach($output as $item): ?>
                <div class="item"><a href="<?=$item[0]?>"><?=$item[0]?></a>, <a href="<?=$item[1]?>"><?=$item[1]?></a>, <?=$item[2]?></div>
            <?php endforeach ?>
        <?php else: ?>
            no results
        <?php endif?>
    </div>
</form>
<script src="simpleapp.js"></script>

</body>
</html>