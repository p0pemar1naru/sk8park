<?php

    @header("HTTP/1.1 404 Not found", true, 404);

    // calling the header.php
    get_header();

    // action hook for placing content above #container
    thematic_abovecontainer();

?>
<!-- MAIN TABLE BEGINS -->
<table class="nob" width="940" border="0" cellspacing="0" cellpadding="0" align="center">
<tr class="nob">
<td colspan="3" align="center">
    <!-- CONTENT TABLE BEGINS -->
    <table class="nob" width="600" border="0" cellspacing="0" cellpadding="0" style="margin-top:80px;">
    <tr class="nob">
        <td width="550">
            <table class="nob" width="550" border="0" cellspacing="0" cellpadding="0">
            <tr class="nob">
                <td width="550" align="center" valign="top">
                    <img src="http://survey.cjskateboardcamp.com/wp-content/uploads/2012/05/404_skateboard.jpg" width="550" height="181" border="0" alt="404 - Not found">
                    <p>Oops! 404, page not found.</p>
                    <p>Perhaps you are here because...</p>
                    <table class="nob" border="0" cellspacing="0" cellpadding="0">
                    <tr class="nob">
                    <td>
                        <ul>
                            <li> The page has moved</li>
                            <li> The page no longer exists</li>
                            <li> You tried some trick and well...</li>
                            <li> You just like 404 pages</li>
                        </ul>
                        </td>
                    </tr>
                    </table>
                    <a href="http://www.cjskateboardcamp.com">Return to home page</a>
                </td>
            </tr>
            </table>
        </td>
    </tr>
    </table>
    <!-- CONTENT TABLE ENDS -->
</td>
</tr>
</table>
<!-- MAIN TABLE ENDS -->
<?php

    // action hook for placing content below #container
    thematic_belowcontainer();

    // calling the standard sidebar 
//    thematic_sidebar();

    // calling footer.php
    get_footer();

?>