<?php
// Show and create new guestbook entries!

if (@$_POST['name']) //assume a new entry needs to be created!
{
    //TODO add a new guest book entry to the .csv file and redirect back to main page if successful, show an error message if not!
}
else
{ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <title>Guestbook</title>
    <link href="../../styles/main.css" rel="stylesheet" type="text/css" />
  </head>
  <body bgcolor="#000000" text="#32CD32">
    <h1>Guestbook</h1>
    <p>In the 1990's just about every site that wasn't a commercial site had a guestbook. It was away for people to leave a message and tell people they were on a site. For the most part these were likely hosted by a third-party company since many free hosting services didn't offer any sort of server-side scripting or application support. Many of these are dead now, so I wrote a quick and easy version here to demonstrate what they were like. Of course, the bonus here is that you get to experience a guestbook! Go ahead and sign it and see what happens!</p>
<?php
//TODO show current guestbook entries!
//TODO show add guestbook form!
?>
  </body>
</html>
<?php }
