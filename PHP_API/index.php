<head></head>

<body class="page_bg">

<br />
<font size='1'><table class='xdebug-error xe-uncaught-exception' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Fatal error: Uncaught PDOException: SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '\n name = 'test123'

            WHERE Uname LIKE 't@t.t' LIMIT 1' at line 2 in C:\wamp\www\szakdoga\API\users.php on line <i>117</i></th></tr>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> PDOException: SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '\n name = 'test123'

            WHERE Uname LIKE 't@t.t' LIMIT 1' at line 2 in C:\wamp\www\szakdoga\API\users.php on line <i>117</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0003</td><td bgcolor='#eeeeec' align='right'>353800</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='C:\wamp\www\szakdoga\API\get.php' bgcolor='#eeeeec'>...\get.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.0129</td><td bgcolor='#eeeeec' align='right'>401528</td><td bgcolor='#eeeeec'>Users->updateUser( <span>$Uname = </span><span>&#39;t@t.t&#39;</span>, <span>$name = </span><span>&#39;test123&#39;</span>, <span>$enc_pass = </span>???, <span>$mobile = </span>???, <span>$tagsag = </span>??? )</td><td title='C:\wamp\www\szakdoga\API\get.php' bgcolor='#eeeeec'>...\get.php<b>:</b>42</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.0129</td><td bgcolor='#eeeeec' align='right'>402000</td><td bgcolor='#eeeeec'><a href='http://www.php.net/PDO.prepare' target='_new'>prepare</a>( <span>$statement = </span><span>&#39;\r\n            Update users\r\n            Set \\n name = \&#39;test123\&#39;\r\n            WHERE Uname LIKE \&#39;t@t.t\&#39; LIMIT 1\r\n            &#39;</span>, <span>$options = </span><span>[0 =&gt; &#39;t@t.t&#39;]</span> )</td><td title='C:\wamp\www\szakdoga\API\users.php' bgcolor='#eeeeec'>...\users.php<b>:</b>117</td></tr>
</table></font>


</body>
</html>