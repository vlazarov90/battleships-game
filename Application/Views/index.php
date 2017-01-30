<?php
$board = $this->board;


if(isset($this->message)){
    echo $this->message;
}
?>
<pre><?php echo $board ?></pre>
<form method="post">
    <label for="shoot">Enter coordinates (row, col), e.g. A5</label>
    <input type="text" name="shoot" autofocus>
    <input type="submit" value="Hit">
</form>
