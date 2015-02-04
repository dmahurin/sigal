<?php
  /** Directory with pictures. */
  $conf['dir'] = './pictures/';
  /** Directory for caching thumbnails (must be writeable!).*/
  $conf['cache'] = './cache/';
  /** URL to default album and picture icon. May be absolute or relative. */
  $conf['defaultIcon'] = '?static=defico';
  /** Name of file with definition of title image. */
  $conf['icotitlefname'] = '000.nfo';
  /** Name of file with defined usernames/passwords for locked/private albums. */
  $conf['lockfname'] = '000.lock';
  /** Width of thumbnail. */
  $conf['thumb_x'] = 160;
  /** Height of thumbnail. */
  $conf['thumb_y'] = 120;
  /** Width of middle size picture - the view size. */
  $conf['middle_x'] = 800;
  /** Number of characters of shortened image title. */
  $conf['imgTitleLen'] = 16;
  /** Title of whole gallery. */
  $conf['galTitle'] = 'SiGal gallery';
  /** String shown in bottom of each page. Designed to some words about legal use of photos. */
  $conf['legal_notice'] = 'No photos can be distributted without written permission of their author (<a href="http://gimli2.gipix.net">Gimli2</a>).';

  /*==========================================================================*/
  /** You can provide own callback function redefine mapping directory name to album name. Function takes a string as 1st argument and returns final string name. */
  $conf['func_albumname'] = '';
  /** You can provide own callback function to define your own grouping of albums. */
  $conf['func_groupname'] = 'onegroup';
  /** Callback function for scanning directory for images. You can implement own filters tanks to this function. */
  $conf['func_scandir'] = '';
  /** You can provide own callback function to sorting of albums. Function takes an array as 1st argument and returns sorted array. */
  $conf['func_sortalbums'] = '';
  /** You can provide own callback function to sorting of images. Function takes an array as 1st argument and returns sorted array. */
  $conf['func_sortimages'] = '';

  function onegroup($basename) {
    return '789';
  }

  /** Example implemantation of getting album name/title from name of directory. */
  function myalbumname($basename) {
    $patterns = array('~(19|20)(\d{2})-(\d{1,2})-(\d{1,2})_(.*)~si',
                      '~(19|20)(\d{2})-(\d{1,2})-(\d{1,2})-(\d{1,2})_(.*)~si');
    $replacements = array('\5 (\4. \3. \1\2)',
                          '\6 (\4-\5. \3. \1\2)');
    $basename = preg_replace($patterns, $replacements , $basename);
    $elipse = (strlen($basename) > 15) ? '&hellip;':'';
    $title = substr($basename, 0, 15).$elipse;
    return $title;
  }
  /** Example implementation of . */
  function mygroupname($bn) {
    // default grouping is by chars before "-"
    $cutpos = strpos($bn, '-');
    if ($cutpos === FALSE) $cutpos = strlen($bn);
    $group = substr($bn, 0, $cutpos);
    return $group;
  }
  /** Example implementation of getting pictures from directory. Usefull eg. when you want to skip some of them. */
  function myscandir($dir) {
    $files = glob($dir.'/*.tiff');
    return $files;
  }
  /** Example implementation of album sorting. */
  function mysortalbums($array) {
    arsort($array);
    return  $array;
  }
  /** Example implementation of images sorting. */
  function mysortimages($array) {
    asort($array);
    return  $array;
  }
?>
