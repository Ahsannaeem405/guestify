<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts.Email.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title><?php echo $title_for_layout;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

    <body bgcolor="#f0f0f0" topmargin="20" leftmargin="20" style="font-family:  Helvetica, Arial, sans-serif; font-size: 10pt; color: #666; padding: 20px; background-color: #f0f0f0;">
        <style type="text/css" media="screen">
            body {
                font-family:  Helvetica, Arial, sans-serif;
                font-size: 10pt;
                color: #666;
                margin: 0;
                padding: 20px;
                background-color: #f0f0f0;
                }
            a, a:link, a:hover { color: #388f58; }
        </style>
        <table width="95%" cellpadding="0" cellspacing="0" border="0" class="bg" style="background-color: #f0f0f0; " >
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" width="610" border="0" align="center" class="main">
                        <tr>
                            <td valign="top">
                                <table cellpadding="0" cellspacing="0" width="610" border="0">
                                    <tr>
                                        <td width="98%" style="padding: 0px;">
                                            <div style="color: #fff; background-color: #059ec7; padding: 5px; font-family:  Helvetica, Arial, sans-serif; border:1px #fff solid; width: 590px; height: 120px; margin: 0px;">
                                                <center><h1 style="margin-top:35px;">Herzlich Willkommen!</h1></center>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="98%" style="padding: 00px;">
                                            <div style="background-color: #fafafa; font-family:  Helvetica, Arial, sans-serif; padding: 20px;  border:1px #fff solid; width: 550px; margin: 0;">
                                                <?php echo $this->fetch('content'); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="98%" style="padding: 0px;">
                                            <div style="background-color: #999999; padding: 20px;  boder:1px #fff solid; width: 550px; margin: 0px;">
                                                <div style="display: block;">
                                                    <div style="font-family:  Helvetica, Arial, sans-serif; font-size: 12px; color: #333;">
                                                        <center>
                                                            <p>
                                                                Copyright &copy; 2014
                                                            </p>
                                                            <p>
                                                                Add some social links here...
                                                            </p>
                                                        </center>
                                                    </div>
                                                </div>
                                                <div>&nbsp;</div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <small></small>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
