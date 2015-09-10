<script>
    var controller_xml;             // store controller php code of all element as xml
    var xmlDoc;                     // store all page information as xml doc file
    var elementCount = 0;
    var currentElementType;         // current draging element type
    var currentElementID;           // element ID for change properties of added element
    var currentDragElementID;       // current dragin element ID
    var dragNewType = false;                   // type of drag. drag for new element or change position of old element
    var currentActionType = 'click';          // store method(click,post) clicked in edit Element windows
    var moduleXML = {};                   // store all html data of module
    var dragModuleID;                   // store current selcted module for drag
	var panelBaiscShow=true;
	var panelModuleShow=true;

	/* 
	* set event to element when it open
	*/
    function setHTMLElement(htmlStr) {
        htmlXml = stringToXml(htmlStr);
		
        // get all element and initialize events'
		var tagList=htmlXml.getElementsByTagName('*');			// break in to all nodes
        for (i = 0; i < tagList.length; i++) {
            var element_id = tagList[i].getAttribute('id');		// get attribute id and add event to that id
            setElementEvent(element_id, "");
        }

    }
	/* 
	* convert xml dom object to string
	*/
    function xmlToString(thexml) {
        if (thexml.xml) {

            xmlString = thexml.xml;
        } else {

            xmlString = (new XMLSerializer).serializeToString(thexml);
        }
        return xmlString;
    }
	
	/* 
	* convert string inoto xml dom object
	*/
    function stringToXml(txt) {
        if (window.DOMParser)
        {
            parser = new DOMParser();
            xmlDocument = parser.parseFromString(txt, "text/xml");
        }
        else
        {
            xmlDocument = new ActiveXObject("Microsoft.XMLDOM");
            xmlDocument.async = false;
            xmlDocument.loadXML(txt);
        }
        return xmlDocument;

    }
	
	/* 
	* set event into element. drop, duoble click, drag, mouse over and mouse out
	*/ 
    function setElementEvent(element_id, element_type) {
        $('#' + element_id).on("drop", {element_ID: element_id}, dropNewElementTo);
        $('#' + element_id).on("dblclick", {element_ID: element_id}, editElement);
        $('#' + element_id).on("drag", {element_ID: element_id}, dragElement);
        $('#' + element_id).on("mouseover", {element_ID: element_id, element_type: element_type}, moveOnElement);
        $('#' + element_id).on("mouseout", {element_ID: element_id}, mouseOutElement);
    }
	
	/* 
	* drop new element into other element
	*/
    function dropNewElementTo(event) {
        event.stopPropagation();
        dropNewElement(event, event.data.element_ID);
    }
	
	/* 
	* set default value in the edit element window
	*/
    function editElement(event) {
        event.stopPropagation();
		// set basic css styles
        currentElementID = event.data.element_ID;
        $('#edit_element_title').html(currentElementID);
        $('#element_ID').val(currentElementID);
        $('#element_width').val($('#' + currentElementID).css("width"));
        $('#element_height').val($('#' + currentElementID).css("height"));
        $('#element_margin_top').val($('#' + currentElementID).css("margin-top"));
        $('#element_margin_right').val($('#' + currentElementID).css("margin-right"));
        $('#element_margin_buttom').val($('#' + currentElementID).css("margin-bottom"));
        $('#element_margin_left').val($('#' + currentElementID).css("margin-left"));
        $('#element_padding_top').val($('#' + currentElementID).css("padding-top"));
        $('#element_padding_right').val($('#' + currentElementID).css("padding-right"));
        $('#element_padding_buttom').val($('#' + currentElementID).css("padding-bottom"));
        $('#element_padding_left').val($('#' + currentElementID).css("padding-left"));

		// if style atribute in the selected element then update  style value into editarea box
        if ($('#' + currentElementID).attr("style") != null) {
            editAreaLoader.setValue('span_css_code', $('#' + currentElementID).attr("style"));
			
        } else {					// if there are no style set yet then set editarea value to empty
            editAreaLoader.setValue('span_css_code', "");
        }
        var xmlTagController = getControllerTagByName(currentElementID, xmlDoc);


        // check element class and according to the class show edit window
        $('.hide_div').hide();
		
		// set name and value of html element
        if ($('#' + currentElementID).hasClass('ct_name')) {
			$('#element_form_name').val(document.getElementById(currentElementID).name);
			$('#element_form_value').val(document.getElementById(currentElementID).value);
			
            $('#div_element_form_name').show();
			$('#div_element_form_value').show();
            
        }
		// set form atribute. action and method
        if ($('#' + currentElementID).hasClass('ct_form')) {
            $('#div_element_form_action').show();
            $('#div_element_form_method').show();

        // set row count and coloumn count for textare
        }if ($('#' + currentElementID).hasClass('ct_rowcol')) {
			$('#element_form_rows').val(document.getElementById(currentElementID).rows);
			$('#element_form_cols').val(document.getElementById(currentElementID).cols);
			
            $('#div_element_form_row').show();
            $('#div_element_form_col').show();
            
            
        }
		// set href value for links
        if ($('#' + currentElementID).hasClass('ct_link')) {
            $('#div_element_link').show();
        }
		
		// set checked attribute for check box and radio buttons
		if ($('#' + currentElementID).hasClass('ct_checked')) {
            $('#div_element_checked').show();
        }
		
		// set php code segment class.
        if ($('#' + currentElementID).hasClass('ct_php')) {
			// remove comment from html element. otherwise it show as comment
            var html_data = $('#' + currentElementID).html().replace('!--', '').replace('--', '');
            editAreaLoader.setValue('span_php_code', html_data);	// set replaced value into editing area
            $('#div_php_span').show();
        }
		
		// set color into html element
        if ($('#' + currentElementID).hasClass('ct_color')) {
            console.log(document.getElementById(currentElementID).bgcolor);
            //$('#div_color').show();
        }
		
		// add html content by editor
        if ($('#' + currentElementID).hasClass('inner_html')) {
            $('#div_element_html_editor').show();
			// remove comment from html element. otherwise it show as comment
            var html_data = $('#' + currentElementID).html().replace('!--', '').replace('--', '');
            CKEDITOR.instances.html_editor.setData(html_data);
        } else {
            CKEDITOR.instances.html_editor.setData('');
        }


        if (xmlTagController != null) {
            console.log(xmlTagController.childNodes[0]);

            editAreaLoader.setValue('controler_code', xmlTagController.childNodes[2].innerHTML);
            if (xmlTagController.childNodes[0].innerHTML == 'post') {
                $('#event_post_button').addClass("active");
                $('#event_click_button').removeClass("active");
            } else if (xmlTagController.childNodes[0].innerHTML == 'click') {
                $('#event_click_button').addClass("active");
                $('#event_post_button').removeClass("active");
            }
        } else {
            editAreaLoader.setValue('controler_code', "");
        }
        $('#div_edit_window').show(200);
    }
	
	// store current draging element
    function dragElement(event) {
        event.stopPropagation();
        dragNewType = false;
        currentDragElementID = event.data.element_ID;

    }
	
	/*
	*	show mouse moved element in bottom of design page
	*/
    function moveOnElement(event) {
        var str = $('#div_status_window').html();
        $('#div_status_window').html(" »  " + event.data.element_ID + str);
        //$('#div_status_window').html(" »  " + event.data.element_ID + " » " + event.data.element_type + "" + str);
    }
	
	/*
	*	if mouse out then clear on mouse moved value
	*/
    function mouseOutElement(event) {
        $('#div_status_window').html("");
    }
	
	/*
	*	preview page by send canvas data into controller and if request success
	* 	then show preview page in new window
	*/
    function previewPage() {
        html_str = $('#canvas').html();
		$.getJSON('<?php echo base_url('index.php/page/setView'); ?>',{data:html_str,page_ID:<?php 
		if (isset($page_ID)) {
			echo $page_ID; 
			$com_ID=$page_ID;
		}else{
			echo "'$module_ID'"; 
			$com_ID=$module_ID;
		} ?>},previewCallBack);
        

    }
	
	/*
	*	if preview page request success then show preview page in new window
	*/
	function previewCallBack(json){
		<?php if (isset($page_ID)) { ?>
		window.open('<?php echo base_url('index.php/page/viewPage?page_ID='.$com_ID); ?>', '_target');
		<?php }else{ ?>
		window.open('<?php echo base_url('index.php/page/viewModule?module_ID='.$com_ID); ?>', '_target');
		<?php } ?>
	}
	
	/*
	*	show properties window
	*/
    function showPropertieWindow() {
        $('#div_css_code_window').hide();
        $('#div_css_edit_window').show();
        $('#li_properties').addClass("active");
        $('#li_css').removeClass("active");

    }
    function showCSSWindow() {
        $('#div_css_code_window').show();
        $('#div_css_edit_window').hide();
        $('#li_properties').removeClass("active");
        $('#li_css').addClass("active");

    }
    function showController() {
        editAreaLoader.setValue('controller_php_code', xmlDoc.getElementsByTagName("control")[0].childNodes[0].nodeValue);
        $('#div_controller_window').show();
    }
    function updateController() {
        xmlDoc.getElementsByTagName("control")[0].childNodes[0].nodeValue = editAreaLoader.getValue('controller_php_code');
        console.log(xmlDoc);
        $('#div_controller_window').hide();
    }
    function closeController() {
        $('#div_controller_window').hide();
    }
	function deleteElement(){
		//alert()
		var element = document.getElementById(currentDragElementID);
		element.parentNode.removeChild(element);
		
	}
	function showHideBasic(){
		if(panelBaiscShow){
			$('#panel_basic').hide(100);
			panelBaiscShow=false;
		}else{
			$('#panel_basic').show(100);
			panelBaiscShow=true;
		}
		
	}
	function showHideModule(){
		if(panelModuleShow){
			$('#panel_module').hide(100);
			panelModuleShow=false;
		}else{
			$('#panel_module').show(100);
			panelModuleShow=true;
		}
		
	}
	function showSettings(){
		$('#div_settings_window').show();
	}
	function closeSettings(){
		$('#div_settings_window').hide();
	}
	function updateSettings(){
		    xmlDoc.getElementsByTagName("name")[0].childNodes[0].nodeValue = $('#page_name').val();
			xmlDoc.getElementsByTagName("description")[0].childNodes[0].nodeValue = $('#page_description').val();
        console.log(xmlDoc);
        $('#div_settings_window').hide();
	}
</script>
<script language="javascript" type="text/javascript" src="<?php echo base_url('public/edit_area/edit_area_full.js') ?>"></script>

<script src="<?php echo base_url('/public/ckeditor/ckeditor.js') ?>"></script>
<div class="userhome-design">
    <div class="form_container-design">
        <div class="row">
            <div class="col-sm-9" style="width:100%">
                <div class="panel panel-default">
                    <?php if (isset($page_ID)) { ?>
                        <div class="panel-heading">Design Page <?php echo $page_detail['page_data'][0]->name . ' ' . $username ?>
                            <div></div>
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="button" class="btn btn-default" onclick="savePage()"><span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>Save</button>
                                <a type="button" class="btn btn-default" target="_blank" href="<?php echo base_url("index.php/page/viewCreatePage"); ?>"><span class="glyphicon glyphicon-file" aria-hidden="true"></span>New Page</a>
                                <button type="button" class="btn btn-default" onclick="showController()"><span class="glyphicon glyphicon-scissors" aria-hidden="true"></span>Controller</button>
                                <button type="button" class="btn btn-default" onclick="showSettings()"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Settings</button>
								<button type="button" class="btn btn-default" onclick="previewPage()"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>Preview</button>

                            </div>


                        </div>
                    <?php } else if (isset($module_ID)) { ?>
                        <div class="panel-heading">Design Module <?php echo simplexml_load_string($module_detail)->detail->name[0] . ' ' . $username ?>
                            <div></div>
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="button" class="btn btn-default"  onclick="savePage()"><span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>Save</button>
                                <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-file" aria-hidden="true"></span>New Page</button>
                                <button type="button" class="btn btn-default" onclick="showSettings()"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Settings</button>
								<button type="button" class="btn btn-default" onclick="previewPage()"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>Preview</button>

                            </div>


                        </div>
                    <?php } ?>

                </div>
                <div class="row">
                    <div class="col-xs-8 col-sm-6" style="width: 20%">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="div_html_component" ondragover="allowDrop(event)" ondrop="deleteElement()">Component<img src="<?php echo base_url('public/image/Recycle_Bin_Full.png') ?>" width="20px" height="20px" style="margin-left:100px"/></div>
                            <div class="panel-body" style="padding: 2px">
                                <div class="panel panel-default" >

                                    <div class="panel-heading" onclick="showHideBasic()">Basic</div>
                                    <font style="font-size: 10px">
                                    <div class="panel-body" style="background-color: #e3e3e3" id="panel_basic">
                                        Layout
                                        <div draggable="true"  ondragstart="drag(event,'row_layout')">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" />
                                            Row
                                        </div>
                                        <div draggable="true" ondragstart="drag(event,'column_layout')">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" />
                                            Column
                                        </div>
                                        <div draggable="true" ondragstart="drag(event,'inner_html')">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" />
                                            Content
                                        </div>
                                        <hr>
                                        Form
                                        <div draggable="true" ondragstart="drag(event,'form')">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" />
                                            Form
                                        </div>
                                        <div draggable="true" ondragstart="drag(event,'button')">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" />
                                            Button
                                        </div>
                                        <div draggable="true" ondragstart="drag(event,'textbox')">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" />
                                            Textbox
                                        </div>
										
										
										
										<div draggable="true" ondragstart="drag(event,'textarea')">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" />
                                            Textarea
                                        </div>
										<div draggable="true" ondragstart="drag(event,'password')">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" />
                                            Password
                                        </div>
										<div draggable="true" ondragstart="drag(event,'submit')">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" />
                                            Submit
                                        </div>
										<div draggable="true" ondragstart="drag(event,'checkbox')">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" />
                                            Checkbox
                                        </div>
										<div draggable="true" ondragstart="drag(event,'radio')">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" />
                                            Radio
                                        </div>
										<div draggable="true" ondragstart="drag(event,'file')">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" />
                                            File
                                        </div>
										<div draggable="true" ondragstart="drag(event,'date')">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" />
                                            Date
                                        </div>
										
										
										
										
										
                                        <div draggable="true" ondragstart="drag(event,'link')">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" />
                                            Link
                                        </div>

                                        <hr>
                                        PHP
                                        <div draggable="true" ondragstart="drag(event,'php_span')">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" />
                                            Code span
                                        </div>


                                    </div>
                                    </font>
                                </div>
                                <div class="panel panel-default" >
                                    <div class="panel-heading" onclick="showHideModule()">Modules</div>
                                    <div class="panel-body" style="background-color: #e3e3e3" id="panel_module">
                                        <font style="font-size: 10px">
                                        <?php
                                        if (isset($all_module_detail)) {
                                            foreach ($all_module_detail as $row) {
                                                $xml_decode = simplexml_load_string($row);
                                                $html_string = preg_replace("#(.*)<view>(.*?)</view>(.*)#is", '$2', $row);
                                                //$xml_string = $xml->view->asXML();
                                                //$html_string=str_replace("</view>", "", str_replace("<view>", "", $xml_string));
                                                $html_string = trim(preg_replace('/\s\s+/', ' ', $html_string));
                                                $html_string = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $html_string);
                                                $html_string = str_replace('<!--ct>', '', str_replace('</ct-->', '', $html_string));
                                                $html_string = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $html_string);
                                                $html_string = preg_replace('/<parsererror\b[^>]*>(.*?)<\/parsererror>/is', "", $html_string);
                                                ?>
                                                <div draggable="true">
                                                    <img src="<?php echo base_url('public/image/button_small.png') ?>" ondragstart="dragModule(event,'<?php echo $xml_decode->detail[0]->name[0] ?>')" />
                                                    <script>
                                                        moduleXML['<?php echo $xml_decode->detail[0]->name[0] ?>'] = '<?php echo $html_string ?>';
                                                    </script>

                                                    <?php
                                                    echo $xml_decode->detail[0]->name[0];
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </font>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-6" style="width: 80%;padding-left: 0px">
                        <div class="panel panel-default">
                            <div class="panel-heading">Canvas</div>
                            <div class="panel-body">
                                <div id="canvas" ondrop="dropNewElement(event, 'canvas')" class="canvas_margin"  ondragover="allowDrop(event)" style="width: 1050px;min-height: 100px">
                                    <?php
                                    if (isset($page_detail['page_xml'])) {
                                        $page_xml = $page_detail['page_xml'];
                                    } else if (isset($module_detail)) {
                                        $page_xml = $module_detail;
                                    }
                                    if (isset($page_xml)) {
                                        //$xml = simplexml_load_string($page_detail['page_xml']);
                                        $html_string = preg_replace("#(.*)<view>(.*?)</view>(.*)#is", '$2', $page_xml);
                                        //$xml_string = $xml->view->asXML();
                                        //$html_string=str_replace("</view>", "", str_replace("<view>", "", $xml_string));
                                        $html_string = trim(preg_replace('/\s\s+/', ' ', $html_string));
                                        $html_string = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $html_string);
                                        $html_string = str_replace('<!--ct>', '', str_replace('</ct-->', '', $html_string));
                                        $html_string = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $html_string);
                                        $html_string = preg_replace('/<parsererror\b[^>]*>(.*?)<\/parsererror>/is', "", $html_string);
                                        print_r($html_string);
                                        ?>


                                    </div>
                                    <script>
                                        var htmlStr = '<?php echo preg_replace('/\r\n|\r|\n/', "", $html_string); ?>';
                                        setHTMLElement(htmlStr);
                                    </script>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="div_edit_window" style="width: 80%;position: fixed;bottom: 0px;top: 80px;left: 100px;bottom: 0px;background-color:#D5E9FF;">
    <div class="panel panel-primary" >
        <div class="panel-heading"><img src="<?php echo base_url('public/image/closebutton.png') ?>" width="20px" height="20px" onclick="closeEditWindow()" /> Edit <span id="edit_element_title"></span></div>
        <div class="panel-body" style="background-color: #ffffff;height: 400px;">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active" onclick="showPropertieWindow()" id="li_properties"><a href="#">Properties</a></li>
                <li role="presentation" onclick="showCSSWindow()" id="li_css"><a href="#">CSS</a></li>


            </ul>
            <div id="div_css_edit_window">
                <div class="row">
                    <div class="col-xs-8 col-sm-6" style="width: 50%">

                        <div class="form-group">

                            <label class="control-label col-xs-2">ID</label>
                            <div class="col-xs-10">
                                <input type="text" id="element_ID"  class="form-control" />

                            </div>
                        </div>
                        <div class="form-group">

                            <label class="control-label col-xs-2">Width</label>
                            <div class="col-xs-10">
                                <input type="text" id="element_width"  class="form-control" />

                            </div>
                        </div>
                        <div class="form-group">

                            <label class="control-label col-xs-2">Height</label>
                            <div class="col-xs-10">
                                <input type="text" id="element_height"  class="form-control" />

                            </div>
                        </div>
                        <div class="form-group">
                            <table>
                                <tr>
                                    <td>
                                        <label class="control-label col-xs-2">Top margin</label>
                                    </td>
                                    <td>
                                        <label class="control-label col-xs-2">Right margin</label>
                                    </td>
                                    <td>
                                        <label class="control-label col-xs-2">Bottom margin</label>
                                    </td>
                                    <td>
                                        <label class="control-label col-xs-2">Left margin</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" id="element_margin_top"  class="form-control" />

                                    </td>
                                    <td>
                                        <input type="text" id="element_margin_right"  class="form-control" />

                                    </td>
                                    <td>
                                        <input type="text" id="element_margin_bottom"  class="form-control" />

                                    </td>
                                    <td>
                                        <input type="text" id="element_margin_left"  class="form-control" />

                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td>
                                        <label class="control-label col-xs-2">Top padding</label>
                                    </td>
                                    <td>
                                        <label class="control-label col-xs-2">Right padding</label>
                                    </td>
                                    <td>
                                        <label class="control-label col-xs-2">Bottom padding</label>
                                    </td>
                                    <td>
                                        <label class="control-label col-xs-2">Left padding</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" id="element_padding_top"  class="form-control" />

                                    </td>
                                    <td>
                                        <input type="text" id="element_padding_right"  class="form-control" />

                                    </td>
                                    <td>
                                        <input type="text" id="element_padding_bottom"  class="form-control" />

                                    </td>
                                    <td>
                                        <input type="text" id="element_padding_left"  class="form-control" />

                                    </td>
                                </tr>
                            </table>




                        </div>

                    </div>
                    <div class="col-xs-8 col-sm-6" style="width: 50%">

						
                        <div class="form-group hide_div" id="div_element_form_name">

                            <label class="control-label col-xs-2">Name</label>
                            <div class="col-xs-10">
                                <input type="text" id="element_form_name"  class="form-control" />
                            </div>
                        </div>
						<div class="form-group hide_div" id="div_element_form_value">

                            <label class="control-label col-xs-2">Value</label>
                            <div class="col-xs-10">
                                <input type="text" id="element_form_value"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group hide_div" id="div_element_form_action">

                            <label class="control-label col-xs-2">Action</label>
                            <div class="col-xs-10">
                                <input type="text" id="element_form_action"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group hide_div" id="div_element_form_method">

                            <label class="control-label col-xs-2">Method</label>
                            <div class="col-xs-10">
                                <select id="element_form_method">
                                    <option value="get">Get</option>
                                    <option value="post">Post</option>
                                    <option value="request">Request</option>
                                </select>
                            </div>
                        </div>
						<div class="form-group hide_div" id="div_element_form_row">

                            <label class="control-label col-xs-2">Rows</label>
                            <div class="col-xs-10">
                                <input type="text" id="element_form_rows"  class="form-control" />
                            </div>
                        </div>
						<div class="form-group hide_div" id="div_element_form_col">

                            <label class="control-label col-xs-2">Cols</label>
                            <div class="col-xs-10">
                                <input type="text" id="element_form_cols"  class="form-control" />
                            </div>
                        </div>
						<div class="form-group hide_div" id="div_element_checked">

                            <label class="control-label col-xs-2">Checked</label>
                            <div class="col-xs-10">
                                <input type="checkbox" id="element_form_checked" />
                            </div>
                        </div>
						
                        <div class="form-group hide_div" id="div_element_link">

                            <label class="control-label col-xs-2">Href</label>
                            <div class="col-xs-10">
                                <input type="text" id="element_link_href"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group hide_div" id="div_color">

                            <label class="control-label col-xs-2">Background color</label>
                            <div class="col-xs-10">
                                <input type="color" id="element_color"  value="#ff0000" />
                            </div>
                        </div>
                        <div class="form-group hide_div" id="div_element_html_editor">

                            <div class="col-xs-10">
                                <input type="button" onclick="showEditHtml()" value="Show Editor" />
                            </div>
                        </div>
                        <div class="form-group hide_div" id="div_php_span">

                            <div class="col-xs-10">

                                <script language="javascript" type="text/javascript">
                                    editAreaLoader.init({
                                        id: "span_php_code"		// textarea id
                                        , syntax: "php"			// syntax to be uses for highgliting
                                        , start_highlight: true		// to display with highlight mode on start-up
                                        , allow_resize: "both"
                                        , min_width: 500
                                        , min_height: 200
                                        , allow_toggle: false
                                    });
                                </script>

                                <div>
                                    <textarea id="span_php_code" name="content" cols="20" rows="10">

                                    </textarea>
                                </div>


                            </div>
                        </div>
                    </div>
                </div
            </div>

        </div>
        <div id="div_css_code_window"  class="form-group hide_div">
            <div class="row">
                <script language="javascript" type="text/javascript">
                    editAreaLoader.init({
                        id: "span_css_code"		// textarea id
                        , syntax: "css"			// syntax to be uses for highgliting
                        , start_highlight: true		// to display with highlight mode on start-up
                        , allow_resize: "both"
                        , min_width: 500
                        , min_height: 200
                        , allow_toggle: false
                    });
                </script>

                <div>
                    <textarea id="span_css_code" name="content" cols="20" rows="10">

                    </textarea>
                </div>
            </div>
        </div>
        <input type="button" value="Update" onclick="updateDesign()" />
    </div>
</div>
</div>
</div>
<h4><div id="div_status_window" class="label label-success" style="position: fixed;bottom: 0px; left: 0px;"></div></h4>




<div id="div_html_editor" class="hide_div" style="width: 80%;position: fixed;bottom: 0px;top: 80px;left: 100px;bottom: 0px;background-color:#D5E9FF;">
    <div class="panel panel-primary" >
        <div class="panel-heading"><img src="<?php echo base_url('public/image/closebutton.png') ?>" width="20px" height="20px" onclick="closeEditHtml()" /> Edit <span id="edit_element_title"></span></div>
        <div class="panel-body" style="background-color: #ffffff;height: 400px;">
            <textarea cols="80" id="html_editor" name="html_editor" rows="10">&lt;p&gt;This is some &lt;strong&gt;sample text&lt;/strong&gt;. You are using &lt;a href="http://ckeditor.com/"&gt;CKEditor&lt;/a&gt;.&lt;/p&gt;</textarea>
            <script>


                CKEDITOR.replace('html_editor', {
                    toolbar: [
                        ['Source', 'Cut', 'Copy', 'Paste', 'Find', 'Replace', 'Bold', 'Italic', "Underline",
                            "Strike", "Subscript", "Superscript", '-', 'NumberedList', 'BulletedList',
                            "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyBlock", 'Link', 'Unlink',
                            "Image", "Flash", "Table", "HorizontalRule", "Smiley", "SpecialChar", "PageBreak", "Iframe"],
                        ["Styles", "Format", 'FontSize', "Font", 'TextColor', 'BGColor', "Maximize"]
                    ]
                });
                $('#html_editor').hide();

            </script>
        </div>
    </div>
</div>


<div id="div_controller_window" style="width: 80%;position: fixed;bottom: 0px;top: 80px;left: 100px;bottom: 0px;background-color:#D5E9FF;"  class="hide_div">
    <div class="panel panel-primary" >
        <div class="panel-heading"><img src="<?php echo base_url('public/image/closebutton.png') ?>" width="20px" height="20px" onclick="closeController()" /> Controller php code <span id="edit_element_title"></span></div>
        <div class="panel-body" style="background-color: #ffffff;height: 400px;">
            <script language="javascript" type="text/javascript">
                editAreaLoader.init({
                    id: "controller_php_code"		// textarea id
                    , syntax: "php"			// syntax to be uses for highgliting
                    , start_highlight: true		// to display with highlight mode on start-up
                    , allow_resize: "both"
                    , min_width: 1000
                    , min_height: 350
                    , allow_toggle: false
                });
            </script>

            <div>
                <textarea id="controller_php_code" name="content" cols="20" rows="10">

                </textarea>
                <input type="button" value="Update" onclick="updateController()" />
            </div>
        </div>
    </div>
</div>
<div id="div_settings_window" style="width: 80%;position: fixed;bottom: 0px;top: 80px;left: 100px;bottom: 0px;background-color:#D5E9FF;"  class="hide_div">
    <div class="panel panel-primary" >
        <div class="panel-heading"><img src="<?php echo base_url('public/image/closebutton.png') ?>" width="20px" height="20px" onclick="closeSettings()" /> Page Settings <span id="edit_element_title"></span></div>
        <div class="panel-body" style="background-color: #ffffff;height: 400px;">
			<div class="form-group">

				<label class="control-label col-xs-2">Page Name</label>
                <div class="col-xs-10">
                    <input type="text" id="page_name"  class="form-control" value="<?php echo $page_detail['page_data'][0]->name ?>"/>
                </div>
            </div>
			<div class="form-group">

				<label class="control-label col-xs-2">Page Description</label>
                <div class="col-xs-10">
                    <input type="text" id="page_description"  class="form-control" value="<?php echo $page_detail['page_data'][0]->description ?>"/>
                </div>
            </div>
			<input type="button" value="Update" onclick="updateSettings()" />
		</div>
	</div>
</div>







<div id="final_html_script" ></div>
<input type="button" value="click" onclick="test()" />

<script lang="javascript">
    $('#div_edit_window').hide();
    $('#div_event_edit_window').hide();

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev, type) {
        currentElementType = type;
        dragNewType = true;
    }
    function dragModule(ev, module_ID) {
        dragModuleID = module_ID
        currentElementType = 'module';
        dragNewType = true;
    }

    function dropNewElement(ev, parent_element_ID) {
        ev.stopPropagation();
        ev.preventDefault();
        if (dragNewType) {
            if (currentElementType == "button") {

                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("push_button", parent_element_ID, "btn btn-primary element ct_name", 'input');
                element.type = "button";
                element.value = "button";
                proxy_element.appendChild(element);

            } else if (currentElementType == "row_layout") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("row_layout", parent_element_ID, "row element_margin element ct_color", 'div');
                proxy_element.appendChild(element);

                //dropEvent(element,"drop",drop(event,element.id));
                //document.getElementById("name").className = "btn btn-primary";
            } else if (currentElementType == "column_layout") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("column_layout", parent_element_ID, "col-xs-8 col-sm-6 element_margin element ct_color", 'div');
                proxy_element.appendChild(element);
            } else if (currentElementType == "form") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("form", parent_element_ID, "form-horizontal form_container element_margin  element ct_form ct_color ct_name", 'form');
                proxy_element.appendChild(element);
            } else if (currentElementType == "textbox") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("textbox", parent_element_ID, "form-control element ct_name", 'input');
                element.type = "text";
                proxy_element.appendChild(element);
            } else if (currentElementType == "inner_html") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("inner_html", parent_element_ID, "row element_margin inner_html element", 'div');
                proxy_element.appendChild(element);
            } else if (currentElementType == "link") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("link", parent_element_ID, "btn btn-primary ct_link element", 'a');
                element.innerHTML = "link";
                proxy_element.appendChild(element);

            } else if (currentElementType == "php_span") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("php_span", parent_element_ID, "row element_margin element ct_php", 'div');
                proxy_element.appendChild(element);

            } else if (currentElementType == "textarea") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("php_span", parent_element_ID, "row form-control element ct_name ct_rowcol", 'textarea');
				element.rows=4;
				element.cols=20;
                proxy_element.appendChild(element);

            } else if (currentElementType == "password") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("php_span", parent_element_ID, "row form-control element ct_name", 'input');
				element.type = "password";
                proxy_element.appendChild(element);

            }else if (currentElementType == "submit") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("php_span", parent_element_ID, "row btn btn-primary element ct_name", 'input');
				element.type = "submit";
                proxy_element.appendChild(element);

            }else if (currentElementType == "checkbox") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("php_span", parent_element_ID, "row element ct_name ct_checked", 'input');
				element.type = "checkbox";
                proxy_element.appendChild(element);

            }else if (currentElementType == "radio") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("php_span", parent_element_ID, "row element ct_name ct_checked", 'input');
				element.type = "radio";
                proxy_element.appendChild(element);

            }else if (currentElementType == "file") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("php_span", parent_element_ID, "row element ct_name", 'input');
				element.type = "file";
                proxy_element.appendChild(element);

            }else if (currentElementType == "date") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("php_span", parent_element_ID, "row element ct_name", 'input');
				element.type = "date";
                proxy_element.appendChild(element);

            } else if (currentElementType == 'module') {
                alert(moduleXML[dragModuleID]);
                $('#' + parent_element_ID).html(moduleXML[dragModuleID]);
                htmlXml = stringToXml(moduleXML[dragModuleID]);
                for (i = 0; i < htmlXml.getElementsByTagName('*').length; i++) {
                    var element_id = htmlXml.getElementsByTagName('*')[i].getAttribute('id');
                    setElementEvent(element_id, "");
                }
                return 0;

            }
            setElementEvent(element.id, currentElementType);

        } else {
            var proxy_element = document.getElementById(parent_element_ID);
            var element = document.getElementById(currentDragElementID);
            proxy_element.appendChild(element);
        }
    }


    function createNewElement(element_type, parent_element_ID, className, element_HTML_type) {
        var element = document.createElement(element_HTML_type);
        //Assign different attributes to the element. 
        var elementID = "#element" + elementCount;
        element.id = "element" + elementCount;  // And the name too?
        element.draggable = "true";
        element.className = className;

        elementCount++;
        //alert(elementID);
        //Append the element in page (in span).  

        return element;
    }


    function updateDesign() {
		var currentElementAttribute;						// store current element attribute from current element
		var editAreaValue;													// other wise it show undefined
		if($('#' + currentElementID).attr("style")!=null){
			currentElementAttribute=$('#' + currentElementID).attr("style");
		}else{
			currentElementAttribute="";
		}
		if(editAreaLoader.getValue('span_css_code')){
			editAreaValue=editAreaLoader.getValue('span_css_code');
		}else{
			editAreaValue="";
		}
        if (editAreaLoader.getValue('span_css_code') != currentElementAttribute) {

            $('#' + currentElementID).attr("style", editAreaLoader.getValue('span_css_code'));
        } else {
            $('#' + currentElementID).css("width", $('#element_width').val());
            $('#' + currentElementID).css("height", $('#element_height').val());
            $('#' + currentElementID).css("margin-top", $('#element_margin_top').val());
            $('#' + currentElementID).css("margin-right", $('#element_margin_right').val());
            $('#' + currentElementID).css("margin-bottom", $('#element_margin_bottom').val());
            $('#' + currentElementID).css("margin-left", $('#element_margin_left').val());
            $('#' + currentElementID).css("padding-top", $('#element_padding_top').val());
            $('#' + currentElementID).css("padding-right", $('#element_padding_right').val());
            $('#' + currentElementID).css("padding-bottom", $('#element_padding_bottom').val());
            $('#' + currentElementID).css("padding-left", $('#element_padding_left').val());
        }

        //$('#' + currentElementID).unbind("mouseover");
        if (currentElementID != $('#element_ID').val()) {
            document.getElementById(currentElementID).id = $('#element_ID').val();
            setElementEvent($('#element_ID').val(), "");
            setActionToXML();
        }
        //deletedTag = xmlDoc.getElementsByTagName("element_id")[0];
        //console.log(CKEDITOR.instances.html_editor.getData());
        if ($('#' + currentElementID).hasClass('inner_html')) {
            $('#' + currentElementID).html(CKEDITOR.instances.html_editor.getData());
        }
        if ($('#' + currentElementID).hasClass('ct_form')) {
            $('#' + currentElementID).attr('action', $('#element_form_action').val());
            $('#' + currentElementID).attr('method', $('#element_form_method').val());
            
            
        }
		if ($('#' + currentElementID).hasClass('ct_rowcol')) {
            $('#' + currentElementID).attr('rows', $('#element_form_rows').val());
            $('#' + currentElementID).attr('cols', $('#element_form_cols').val());
            
            
        }
		
        if ($('#' + currentElementID).hasClass('ct_name')) {
            $('#' + currentElementID).attr('name', $('#element_form_name').val());
			$('#' + currentElementID).attr('value', $('#element_form_value').val());
        }
        if ($('#' + currentElementID).hasClass('ct_link')) {
            $('#' + currentElementID).attr('href', $('#element_link_href').val());
        }
        if ($('#' + currentElementID).hasClass('ct_php')) {
            $('#' + currentElementID).html(editAreaLoader.getValue('span_php_code'));
        }


        //document.getElementById('canvas').getContext('2d').save();
        $('#div_edit_window').hide();
    }
    // Update the xmlDoc when update action
    function setActionToXML() {
        var node = getControllerTagByName(currentElementID, xmlDoc);
        var xmlControl;
        if (node == null) {
            var txtControl = "<event><action>" + currentActionType +
                    "</action><element_id>" + currentElementID +
                    "</element_id><code>" + editAreaLoader.getValue('controler_code') +
                    "</code></event>";
            xmlControl = stringToXml(txtControl);
            xmlDoc.getElementsByTagName("control")[0].appendChild(xmlControl.documentElement);
            console.log(xmlDoc);
        } else {
            node.childNodes[0].innerHTML = currentActionType;
            node.childNodes[2].innerHTML = editAreaLoader.getValue('controler_code');
            console.log(xmlDoc);
        }

    }
    function closeEditWindow() {
        event.stopPropagation();
        $('#div_edit_window').hide();
    }
    function closeEditHtml() {
        $('#div_html_editor').hide();
    }
    function showEditHtml() {
        $('#div_html_editor').show();
    }

    function callNone() {

    }
    function test() {
        //var text = '{"element_ID":{"click":"abc","post":" "}}';

        //var obj = JSON.parse(text);
        //console.log(obj);
        testw = "llllo abce testto";
        alert(testw.replace('/ab[]te/g', ""));

    }
    // get xml node of the searched element id
    function getControllerTagByName(searchElementID, xml) {
        var nameList = xml.getElementsByTagName('event');

        for (var i = 0; i < nameList.length; i++) {
            //console.log(nameList[i].childNodes[1].innerHTML);
            if (searchElementID == nameList[i].childNodes[1].innerHTML) {

                //parentNode = <emp>
                //lastChild = <score>

                return nameList[i];
                //print name here
            }
        }
    }
    function getControllerTagBy2Name(searchElementID, method, xml) {
        var nameList = xml.getElementsByTagName('event');

        for (var i = 0; i < nameList.length; i++) {
            //console.log(nameList[i].childNodes[1].innerHTML);
            if (searchElementID == nameList[i].childNodes[1].innerHTML && method == nameList[i].childNodes[0].innerHTML) {

                //parentNode = <emp>
                //lastChild = <score>

                return nameList[i];
                //print name here
            }
        }
    }
    //function test(event, val) {

    //event.stopPropagation();
    //alert(val);
    //}

    var xmlElement;
    function savePage() {

        var html_str = $('#canvas').html().replace(/\s\s+/g, "").replace("!--", '').replace("--", "");
        var createdView = "<view><!--ct>" + html_str + "</ct--></view>";
        xmlElement = stringToXml(createdView);
        deletedTag = xmlDoc.getElementsByTagName("view")[0];
        xmlDoc.documentElement.removeChild(deletedTag);
        xmlDoc.getElementsByTagName("module")[0].appendChild(xmlElement.getElementsByTagName("view")[0]);

        //xmlDoc.getElementsByTagName("module")[0].appendChild(xmlElement);
        //console.log(xmlDoc.getElementsByTagName("view")[0].childNodes[0].innerHTML);
        console.log(xmlDoc);
        var postXMLDoc = xmlToString(xmlDoc);
        console.log(createdView);
<?php if (isset($page_ID)) { ?>
            $.getJSON("<?php echo base_url('index.php/Main/savePage') ?>", {xml: postXMLDoc, page_ID:<?php echo $page_detail['page_data'][0]->page_ID ?>}, savePageResult);
<?php } else if (isset($module_ID)) { ?>
            $.getJSON("<?php echo base_url('index.php/Main/saveModule') ?>", {xml: postXMLDoc, module_ID: '<?php echo $module_ID ?>'}, saveModuleResult);

<?php } ?>
    }
    function savePageResult(json) {
        if (json[0] == 1) {                 // save page complete
            alert('sucess');
        }
    }
    function saveModuleResult(json) {
        if (json[0] == 1) {                 // save page complete
            alert('sucess');
        }
    }

<?php if (isset($page_xml)) { ?>
        createFromXMLObject();
        function createFromXMLObject() {
            xmlDoc = stringToXml('<?php echo preg_replace('/\r\n|\r|\n/', "", preg_replace('/<parsererror\b[^>]*>(.*?)<\/parsererror>/is', "", preg_replace('/<script>var htmlStr = (.*?);setHTMLElement\(htmlStr\);<\/script>/is', "", $page_xml))); ?>');
        }
<?php } else { ?>
        createNewXMLObject();
        function createNewXMLObject() {
            txt = "<module>";
            txt += "<detail>";
            txt += "<name><?php
    if (isset($module_ID)) {
        echo $module_ID;
    } else {
        echo $page_ID;
    }
    ?></name>";
            txt += "<description></description>";
            txt += "</detail>";
            txt += "<view>";
            txt += "</view>";
            txt += "<control>";
            txt += "</control>";
            txt += "</module>";

            xmlDoc = stringToXml(txt);
            alert(xmlDoc.getElementsByTagName("name")[0].childNodes[0].nodeValue);

        }
<?php } ?>





</script>
<div id="h1">
    <div id="h2">
        <div id="h3">abc</div>
    </div>
</div>

