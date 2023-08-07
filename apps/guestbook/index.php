<?php
// Show and create new guestbook entries!

class FileCSV
{
  public $uri;
  public $raw;

  public function __construct($uri)
  {
    $this->uri=$uri;
    if (is_file($uri) && (is_readable($uri)))
    {
      $this->raw=trim(file_get_contents($uri));
    }
  }

  public function read()
  {
    $lines=explode(PHP_EOL,$this->raw);
    $cols=str_getcsv($lines[0]);
    unset ($lines[0]);
    $data=array();
    foreach ($lines as $line)
    {
      $row=str_getcsv($line);
      $col_index=0;
      foreach ($row as $val)
      {
        $row_data[$cols[$col_index]]=$val;
        $col_index++;
      }
      unset($col_index);
      $data[]=$row_data;
    }
    return $data;
  }

  public function write(array $data)
  {
    if (is_array($data))
    {
      if (empty($this->raw))
      {
        $cols=array_keys($data[0]);
        $csv=implode(",",$cols); //uses column names as first row of CSV data
        unset($cols);
        $csv=trim($csv,",")."\n";
      }
      else
      {
        $csv=$this->raw."\n";
      }

      foreach ($data as $row)
      {
        foreach ($row as $val)
        {
          $csv.="\"".$val."\",";
        }
        $csv=trim($csv,",")."\n";
      }

      return file_put_contents($this->uri,$csv);
    }
  }
}

$file=new FileCSV("./entries.csv");

if (@$_POST['Send']) //assume a new entry needs to be created!
{
    //TODO add a new guest book entry to the .csv file and redirect back to main page if successful, show an error message if not!
    $data[0]=$_POST; //Creates a row as expected by FileCSV::write()
    if ($file->write($data))
    {
      header ("Location: index.php");
    }
    else
    { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <title>Guestbook - Error</title>
    <link href="../../styles/main.css" rel="stylesheet" type="text/css" />
  </head>
  <body bgcolor="#000000" text="#32CD32">
    <h1>Guestbook - Error</h1>
    <p>We apologize, but it appears there was an error while attempting process your message. Please <a href="javascript:history.back()">go back</a> and try again!</p>
  </body>
</html>
    <?php }
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
date_default_timezone_set("America/Los_Angeles");
$entries=$file->read();
foreach ($entries as $entry)
{
  if (!empty($entry['Email']) && !empty($entry['Name']))
  {
    $author="<a href=\"mailto:{$entry['Email']}\">{$entry['Name']}</a>";
  }
  elseif (!empty($entry['Name']))
  {
    $author="{$entry['Name']}";
  }
  elseif (!empty($entry['Email']))
  {
    $author="<a href=\"mailto:{$entry['Email']}\">{$entry['Email']}</a>";
  }
  else
  {
    $author="Anonymous";
  }

  $posted=date("d M Y g:i A T",$entry['Timestamp']);

  print "<div class=\"guestbook entry\" id=\"{$entry['Timestamp']}\">\n<div class=\"info\">{$author} - {$posted}</div>\n<div class=\"message\"><p>{$entry['Message']}</p></div>\n</div>\n";
}
?>
   <div id="newEntry" class="form">
     <form action="index.php" method="post">
       <label for="entryName">Name:</label>
       <input id="entryName" type="text" maxlength="50" name="Name" />
       <label for="entryEmail">Email:</label>
       <input id="entryEmail" type="email" name="Email" />
       <input type="hidden" name="Timestamp" value="<?php print time() ?>" />
       <label for="entryText">Message:</label>
       <textarea id="entryText" name="Message" rows="10"></textarea>
       <input type="submit" name="Send" value="Sign" />
     </form>
   </div>
  </body>
</html>
<?php }
