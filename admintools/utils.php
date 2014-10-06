function open_rw()
{
  global $linkid;

  if (!$linkid)
  {
    $newlink = mysql_connect("mydvdcollection.db.10809344.hostedresource.com","mydvdcollection","C@tlov3r");
  }
  else
  {
    $newlink = $linkid;
  }
  if ($newlink)
  {
    mysql_selectdb("mydvdcollection");
  }
  return $newlink;
}