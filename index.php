<?php
  /*========================================================================*/

  /*START-DO-NOT-REMOVE-THIS*/

  /*========================================================================*/
  @set_time_limit(120);

  include_once 'sigal.class.php';
  include_once 'zipstream.class.php';
  $gg = new Sigal();

  /* load additional configuration */
  $conf = array();
  if (file_exists('./config.php')) include './config.php';
  $kws = array('dir', 'cache', 'defaultIcon', 'icotitlefname', 'lockfname', 'thumb_x', 'thumb_y', 'middle_x', 'imgTitleLen', 'galTitle', 'legal_notice', 'date_format',
          'func_sortimages', 'func_sortalbums', 'func_scandir', 'func_albumname', 'func_groupname', 'func_getalbums', 'func_videoimage', 'func_avfileplay');
  foreach ($kws as $item) {
    if (isset($conf[$item])) $gg->$item = $conf[$item];
  }
  if(isset($gg->func_videoimage)) {
    $gg->extsIcon = array_merge($gg->extsIcon, $gg->extsVideo);
  }
  /*========================================================================*/
  /**
   * Display credit page.
   */
  if (isset($_GET['credits'])) {
    $gg->showCreditPage();
    die();
  }
  /*========================================================================*/
  if (isset($_GET['dlselected'])) {
    $gg->downloadZippedImages();
  }
  /*========================================================================*/
  if (isset($_GET['mkmid'])) {
    $gg->makeMiddleImage($_GET['mkmid']);
  }
  /*========================================================================*/
  if (isset($_GET['mkthumb'])) {
    $gg->makeThumbImage($_GET['mkthumb']);
  }
  /*========================================================================*/
  if (isset($_GET['foto'])) {
    session_start();
    if (isset($_POST['fakce']) && $_POST['fakce']==='addaccess') $gg->addAccess();
    $gg->showImage($_GET['foto']);
    die();
  }
  /*========================================================================*/
  if (isset($_GET['alb'])) {
    session_start();
    if (isset($_POST['fakce']) && $_POST['fakce']==='addaccess') $gg->addAccess();
    $gg->showAlbum($_GET['alb']);
    die();
  }
  /*========================================================================*/
  if (isset($_GET['avfile'])) {
    $gg->showVideo($_GET['avfile']);
    die();
  }
  /*========================================================================*/
  // jen pro vyvoj neminifikovane verze
  if (isset($_GET['static'])) {
    header('Location: index.min.php?static='.$_GET['static']);
  }
  /*========================================================================*/
  $gg->showGallery();
