<?php






?>

<form action="./test_proc.php" method="POST" name="test_data" />
<input type="hidden" name="w_type" value="insert_ep" />
공사명 : <input type="text" name="g_name" /><br />
공사등급 :
<input type="radio" name="grade" value="1" />관급(A급)
<input type="radio" name="grade" value="2" />사급(B급)
<br />
<input type="radio" name="i_tree" value="1" />교목
<input type="radio" name="i_tree" value="2" />관목
<br />
<br />
품목 : <input type="text" name="item[]" /><br />
규격 : H<input type="text" name="size1[]" /> x W<input type="text" name="size2[]" />(m)
<br />
수량 : <input type="text" name="osum[]" /><br />
<br />
품목 : <input type="text" name="item[]" /><br />
규격 : H<input type="text" name="size1[]" /> x W<input type="text" name="size2[]" />
<br />
수량 : <input type="text" name="osum[]" /><br />
<br />
품목 : <input type="text" name="item[]" /><br />
규격 : H<input type="text" name="size1[]" /> x W<input type="text" name="size2[]" />
<br />
수량 : <input type="text" name="osum[]" /><br />
<br />
품목 : <input type="text" name="item[]" /><br />
규격 : H<input type="text" name="size1[]" /> x W<input type="text" name="size2[]" />
<br />
수량 : <input type="text" name="osum[]" /><br />
<br />
납품현장 : <input type="text" name="g_place" /><br />
납품날짜 : <input type="text" name="d_date" /><br />
요청사항 : <input type="text" name="etc" /><br />
개찰마감일 : <input type="text" name="e_date" /><br />

<input type="submit" value="신청" />

</form>
