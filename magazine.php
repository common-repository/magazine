<?php
/**
 * Plugin Name:       Magazine
 * Plugin URI:        https://wordpress.org/plugins/magazine/
 * Description:       Create PDFs from your Posts and Pages using the printcss.cloud for PDF generation.
 * Version:           0.0.3
 * Requires at least: 5.7
 * Requires PHP:      7.2
 * Author:            Andreas Zettl
 * Author URI:        https://azettl.net/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Plugin Options START
 */

    function magazine_option_page() {
        $magazine_rendering_tool = get_option('magazine_rendering_tool');
        $magazine_rapidapi_key   = get_option('magazine_rapidapi_key');
        $magazine_print_css      = get_option('magazine_print_css');
        $magazine_print_html     = get_option('magazine_print_html');
        $magazine_print_js       = get_option('magazine_print_js');

        echo '<div class="wrap">
                <div id="icon-options-general" class="icon32"><br /></div>
                <h2>Magazine</h2>
                <form name="magazine_options_form" method="post">
                <table class="form-table">
                    <tr valign="top">
                    <th scope="row">Rendering Tool</th>
                    <td>
                        <fieldset>
                        <legend class="hidden">Rendering Tool</legend>
                        <select name="magazine_rendering_tool" style="width:100%;display:block;">
                            <option value="weasyprint" '. (($magazine_rendering_tool == 'weasyprint') ? 'selected="selected"' : '') .'>WeasyPrint</option>
                            <option value="pagedjs" '. (($magazine_rendering_tool == 'pagedjs') ? 'selected="selected"' : '') .'>PagedJS</option>
                            <option value="vivliostyle" '. (($magazine_rendering_tool == 'vivliostyle') ? 'selected="selected"' : '') .'>Vivliostyle</option>
                        </select>
                        <label for="magazine_rendering_tool">
                            Check out the Tools Websites for more information about their capabilities: <a href="https://weasyprint.org/" target="_blank" rel="noopener">WeasyPrint</a>, <a class="hover:text-gray-900" href="https://www.pagedjs.org/" target="_blank" rel="noopener">PagedJS</a>, and <a class="hover:text-gray-900" href="https://vivliostyle.org/" target="_blank" rel="noopener">Vivliostyle</a>.
                        </label>
                        </fieldset>
                    </td>
                    </tr>
                    <tr valign="top">
                    <th scope="row">RapidAPI Key</th>
                    <td>
                        <fieldset>
                        <legend class="hidden">RapidAPI Key</legend>
                        <input name="magazine_rapidapi_key" value="'. $magazine_rapidapi_key .'" style="width:100%;display:block;" />
                        <label for="magazine_rapidapi_key">
                            <b>To send the request to the PrintCSS Cloud API, you <a href="https://rapidapi.com/azettl/api/printcss-cloud/pricing">need to subscribe to a plan on RapidAPI</a>. With this, you get the API key that is required to authenticate with our REST service.</b>
                        </label>
                        </fieldset>
                    </td>
                    </tr>
                    <tr valign="top">
                    <th scope="row">Print HTML Template</th>
                    <td>
                        <fieldset>
                        <legend class="hidden">Print HTML Template</legend>
                        <textarea name="magazine_print_html" />'. htmlentities($magazine_print_html) .'</textarea>
                        <div id="magazine_print_html">'. htmlentities($magazine_print_html) .'</div>
                        <label for="magazine_print_html">
                            The placeholder <i>{{title}}</i> and <i>{{content}}</i> are for the post/page title and content.
                        </label>
                        </fieldset>
                    </td>
                    </tr>
                    <tr valign="top">
                    <th scope="row">Print CSS</th>
                    <td>
                        <fieldset>
                        <legend class="hidden">Print CSS</legend>
                        <textarea name="magazine_print_css" />'. $magazine_print_css .'</textarea>
                        <div id="magazine_print_css">'. $magazine_print_css .'</div>
                        <label for="magazine_print_css">
                            Add your Print CSS Code here.
                        </label>
                        </fieldset>
                    </td>
                    </tr>
                    <tr valign="top">
                    <th scope="row">Additional JavaScript</th>
                    <td>
                        <fieldset>
                        <legend class="hidden">Additional JavaScript</legend>
                        <textarea name="magazine_print_js" />'. $magazine_print_js .'</textarea>
                        <div id="magazine_print_js">'. $magazine_print_js .'</div>
                        <label for="magazine_print_js">
                            Add your additional JavaScript Code here, be aware that only PagedJS and Vivliostyle support JavaScript.
                        </label>
                        </fieldset>
                    </td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
                </p>
                <input name="action" value="magazin_update_options" type="hidden" />
                </form>
            </div>
            <script src="' . plugin_dir_url( __DIR__ ). '/magazine/javascript/jquery.js"></script>
            <script src="' . plugin_dir_url( __DIR__ ). '/magazine/javascript/ace/ace.js"></script>
            <script src="' . plugin_dir_url( __DIR__ ). '/magazine/javascript/ace/emmet.js"></script>
            <script src="' . plugin_dir_url( __DIR__ ). '/magazine/javascript/ace/ace-ext-emmet.js"></script>
            <script>
                $(document).ready(function() {
                    var htmlEditor = ace.edit("magazine_print_html");
                    htmlEditor.session.setMode("ace/mode/html");
                    htmlEditor.setOption("enableEmmet", true);
                    htmlEditor.session.setTabSize(2);
                    htmlEditor.session.on("change", function(){
                        $(\'textarea[name="magazine_print_html"]\').val(htmlEditor.session.getValue());
                    });

                    var cssEditor = ace.edit("magazine_print_css");
                    cssEditor.session.setMode("ace/mode/css");
                    cssEditor.session.setTabSize(2);
                    cssEditor.session.on("change", function(){
                        $(\'textarea[name="magazine_print_css"]\').val(cssEditor.session.getValue());
                    });

                    var jsEditor = ace.edit("magazine_print_js");
                    jsEditor.session.setMode("ace/mode/javascript");
                    jsEditor.session.setTabSize(2);
                    jsEditor.session.on("change", function(){
                        $(\'textarea[name="magazine_print_js"]\').val(jsEditor.session.getValue());
                    });
                });
            </script>
            <style>
                textarea[name="magazine_print_html"], textarea[name="magazine_print_css"], textarea[name="magazine_print_js"]{
                    display:none;
                }
                #magazine_print_html, #magazine_print_css, #magazine_print_js{
                    height: 400px;
                    width: 100%;
                    font-size: 14px;
                }
            </style>';
    }

    function magazine_add_menu() {
        add_option("magazine_rendering_tool",   "pagedjs");
        add_option("magazine_rapidapi_key",     "");
        add_option("magazine_print_html",       "<h1>{{title}}</h1>\n{{content}}");
        add_option("magazine_print_css",        "@page{\n\tsize:A4;\n}");
        add_option("magazine_print_js",         "");

        add_options_page('Magazine', 'Magazine', 9, __FILE__, 'magazine_option_page');
    }

    if ('magazin_update_options' === $_POST['action']){
        update_option("magazine_rendering_tool", $_POST['magazine_rendering_tool']);
        update_option("magazine_rapidapi_key",   $_POST['magazine_rapidapi_key']);
        update_option("magazine_print_html",     $_POST['magazine_print_html']);
        update_option("magazine_print_css",      $_POST['magazine_print_css']);
        update_option("magazine_print_js",       $_POST['magazine_print_js']);
    }

    add_action('admin_menu', 'magazine_add_menu');

/**
 * Plugin Options END
 */

###############################################################################################################

/**
 * Post Bulk Action Start
 */

    add_filter( 'bulk_actions-edit-post', 'magazine_render_pdf_bulk_actions');
    add_filter( 'bulk_actions-edit-page', 'magazine_render_pdf_bulk_actions');
    
    function magazine_render_pdf_bulk_actions($bulk_actions) {
        $bulk_actions['magazine_render_pdf_bulk_action'] = __( 'Render PDF', 'magazine_render_pdf');

        return $bulk_actions;
    }

    add_filter('handle_bulk_actions-edit-post', 'magazine_render_pdf_bulk_handler', 10, 3);
    add_filter('handle_bulk_actions-edit-page', 'magazine_render_pdf_bulk_handler', 10, 3);
    
    function magazine_render_pdf_bulk_handler($redirect_to, $doaction, $post_ids) {
        if ($doaction !== 'magazine_render_pdf_bulk_action') {
            
            return $redirect_to;
        }

        $magazine_rendering_tool = get_option('magazine_rendering_tool');
        $magazine_rapidapi_key   = get_option('magazine_rapidapi_key');
        $magazine_print_css      = get_option('magazine_print_css');
        $magazine_print_html     = get_option('magazine_print_html');
        $magazine_print_js       = get_option('magazine_print_js');
        $magazine_print_html_tmp = '';

        foreach ( $post_ids as $post_id ) {
            $magazine_print_html_tmp .= str_replace(
                [
                    '{{title}}',
                    '{{content}}'
                ],
                [
                    get_the_title($post_id),
                    apply_filters('the_content', get_post_field('post_content', $post_id))
                ],
                $magazine_print_html
            );
        }

        $curl = curl_init();
        if(trim($magazine_print_js) === ''){
            $oSend = [
                "html" => $magazine_print_html_tmp,
                "css" => $magazine_print_css,
                "options" => [
                    "renderer" => $magazine_rendering_tool
                ]
            ];
        }else{
            $oSend = [
                "html" => $magazine_print_html_tmp,
                "css" => $magazine_print_css,
                "javascript" => $magazine_print_js,
                "options" => [
                    "renderer" => $magazine_rendering_tool
                ]
            ];
        }

        curl_setopt_array(
            $curl, 
            array(
                CURLOPT_URL => 'https://printcss-cloud.p.rapidapi.com/render',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($oSend),
                CURLOPT_HTTPHEADER => array(
                    'x-rapidapi-host: printcss-cloud.p.rapidapi.com',
                    'x-rapidapi-key: ' . $magazine_rapidapi_key
                ),
            )
        );
        $pdfContent = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if($http_status == 200){
            $upload_dir = wp_upload_dir();
            $filename   = 'magazin.' . implode('.', $post_ids) . '-' . date('Y-m-d-H-i-s') . '.pdf';

            if ( wp_mkdir_p( $upload_dir['path'] . '/magazine' ) ) {
                $file = $upload_dir['path'] . '/magazine/'. $filename;
            }
            else {
                $file = $upload_dir['basedir'] . '/magazine/'. $filename;
            }

            file_put_contents($file, $pdfContent);

            $wp_filetype = wp_check_filetype($filename, null);

            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name($filename),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment($attachment, $file);
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
            wp_update_attachment_metadata( $attach_id, $attach_data );
            $redirect_to = add_query_arg( 'magazine_pdf_content_attachment', $attach_id, $redirect_to);
        }else{
            $oError      = json_decode($pdfContent);
            $redirect_to = add_query_arg( 'magazine_pdf_content_error', $oError->message, $redirect_to);
        }

        $redirect_to = add_query_arg( 'magazine_pdf_content', 1, $redirect_to);
        return $redirect_to;
    }

    add_action('admin_notices', 'magazine_render_pdf_action_admin_notice');
    
    function magazine_render_pdf_action_admin_notice() {
        if (!empty($_REQUEST['magazine_pdf_content_attachment'])) {
            print( '<div id="message" class="updated fade">PDF generation done, 
            <a download href="' . wp_get_attachment_url($_REQUEST['magazine_pdf_content_attachment']) 
            . '">download the PDF here</a>
            </div>');
        }else if(!empty($_REQUEST['magazine_pdf_content_error'])){
            print( '<div id="message" class="error fade">Error "' 
                . $_REQUEST['magazine_pdf_content_error'] .'" generating PDF file.</div>');
        }
    }

/**
 * Post Bulk Action End
 */

###############################################################################################################
 
/**
 * Frontend Render PDF Start
 */

/**
 * Frontend Render PDF END
 */
