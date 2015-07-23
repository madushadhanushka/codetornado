<div class="userhome-design">
    <div class="form_container-design">
        <div class="row">
            <div class="col-sm-9" style="width:100%">
                <div class="panel panel-default"">
                    <div class="panel-heading">Design Page <?php echo $page_detail['page_data'][0]->name ?>
                        <input type="button" value="Save" onclick="savePage()" class="btn btn-primary" /></div>
                </div>
                <div class="row">
                    <div class="col-xs-8 col-sm-6" style="width: 20%">
                        <div class="panel panel-default">
                            <div class="panel-heading">Component</div>
                            <div class="panel-body" style="padding: 2px">
                                <div class="panel panel-default" >
                                    <font style="font-size: 10px">
                                    <div class="panel-heading">Basic</div>
                                    <div class="panel-body" style="background-color: #e3e3e3">
                                        Layout
                                        <div draggable="true">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" ondragstart="drag(event,'row_layout')" />
                                            Row
                                        </div>
                                        <div draggable="true">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" ondragstart="drag(event,'column_layout')" />
                                            Column
                                        </div>
                                        <hr>
                                        Form
                                        <div draggable="true">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" ondragstart="drag(event,'form')" />
                                            Form
                                        </div>
                                        <div draggable="true">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" ondragstart="drag(event,'button')" />
                                            Button
                                        </div>
                                        <div draggable="true">
                                            <img src="<?php echo base_url('public/image/button_small.png') ?>" ondragstart="drag(event,'textbox')" />
                                            Textbox
                                        </div>


                                    </div>
                                    </font>
                                </div>
                                <div class="panel panel-default" >
                                    <div class="panel-heading">Modules</div>
                                    <div class="panel-body" style="background-color: #e3e3e3">
                                        asldfkj
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-6" style="width: 80%;padding-left: 0px">
                        <div class="panel panel-default">
                            <div class="panel-heading">Page Preview</div>
                            <div class="panel-body">
                                <div id="canvas" ondrop="dropNewElement(event, 'canvas')"  ondragover="allowDrop(event)" style="width: 1050px;min-height: 100px">
                                    <?php
                                    if (isset($page_detail['page_xml'])) {
                                        $xml = simplexml_load_string($page_detail['page_xml']);
                                        $xml_string = $xml->view->asXML();
                                        echo str_replace("<view>", "", $xml_string);
                                        ?>

<?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="div_edit_window" style="width: 80%;height: 80%;position: absolute;top: 50px;left: 100px;background-color:#D5E9FF;">
    <div class="panel panel-primary" >
        <div class="panel-heading"><img src="<?php echo base_url('public/image/closebutton.png') ?>" width="20px" height="20px" onclick="closeEditWindow()" /> Basic</div>
        <div class="panel-body" style="background-color: #ffffff;height: 400px;">
            <ul class="nav nav-tabs">
                <li class="active" onclick="showPropertieWindow()" id="li_properties"><a href="#">Properties</a></li>
                <li id="li_event"><a href="#" onclick="showEventWindow()">Event</a></li>


            </ul>
            <div id="div_css_edit_window">
                <div class="row">
                    <div class="col-xs-8 col-sm-6" style="width: 50%">

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

                    </div>
                </div
            </div>
            <input type="button" value="Update" onclick="updateDesign()" />
        </div>
        <div id="div_event_edit_window">
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-default active">Click</button>
                <button type="button" class="btn btn-default">Mouse move</button>
                <button type="button" class="btn btn-default">Post</button>
            </div>

            <script language="javascript" type="text/javascript" src="<?php echo base_url('public/edit_area/edit_area_full.js') ?>"></script>
            <script language="javascript" type="text/javascript">
                editAreaLoader.init({
                    id: "textarea_1"		// textarea id
                    , syntax: "php"			// syntax to be uses for highgliting
                    , start_highlight: true		// to display with highlight mode on start-up
                    , allow_resize: "both"
                    , min_width: 700
                    , min_height: 200
                    , allow_toggle: false
                });
            </script>

            <div>
                <textarea id="textarea_1" name="content" cols="20" rows="10">
$hello='prel';
function hello(){
    test();
}
                </textarea>
            </div>

        </div>
    </div>
</div>
</div>
<h4><div id="div_status_window" class="label label-success" style="position: absolute;bottom: 0px; left: 0px;"></div></h4>
<div id="final_html_script" ></div>
<div class="btn-group">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Action <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="#">Action</a></li>
        <li><a href="#">Another action</a></li>
        <li><a href="#">Something else here</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Separated link</a></li>
    </ul>
</div>
<script lang="javascript">
    $('#div_edit_window').hide();
    $('#div_event_edit_window').hide();
    var xmlDoc;                     // store all page information as xml doc file
    var elementCount = 0;
    var currentElementType;         // current draging element type
    var currentElementID;           // element ID for change properties of added element
    var currentDragElementID;       // current dragin element ID
    var dragNewType = false;                   // type of drag. drag for new element or change position of old element
    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev, type) {
        currentElementType = type;
        dragNewType = true;
    }

    function dropNewElement(ev, parent_element_ID) {
        ev.stopPropagation();
        ev.preventDefault();
        if (dragNewType) {
            if (currentElementType == "button") {

                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("push_button", parent_element_ID, "btn btn-primary", 'input');
                element.type = "button";
                element.value = "button";
                proxy_element.appendChild(element);

            } else if (currentElementType == "row_layout") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("row_layout", parent_element_ID, "row element_margin", 'div');
                proxy_element.appendChild(element);

                //dropEvent(element,"drop",drop(event,element.id));
                //document.getElementById("name").className = "btn btn-primary";
            } else if (currentElementType == "column_layout") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("column_layout", parent_element_ID, "col-xs-8 col-sm-6 element_margin", 'div');
                proxy_element.appendChild(element);
            } else if (currentElementType == "form") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("form", parent_element_ID, "form-horizontal form_container element_margin", 'form');
                proxy_element.appendChild(element);
            } else if (currentElementType == "textbox") {
                var proxy_element = document.getElementById(parent_element_ID);
                var element = createNewElement("textbox", parent_element_ID, "form-control", 'text');
                proxy_element.appendChild(element);
            }
            $('#' + element.id).on("drop", {element_ID: element.id}, dropNewElementTo);
            $('#' + element.id).on("dblclick", {element_ID: element.id}, editElement);
            $('#' + element.id).on("drag", {element_ID: element.id}, dragElement);
            $('#' + element.id).on("mouseover", {element_ID: element.id, element_type: currentElementType}, moveOnElement);
            $('#' + element.id).on("mouseout", {element_ID: element.id}, mouseOutElement);
        } else {
            var proxy_element = document.getElementById(parent_element_ID);
            var element = document.getElementById(currentDragElementID);
            proxy_element.appendChild(element);
        }
    }
    function dragElement(event) {
        event.stopPropagation();
        dragNewType = false;
        currentDragElementID = event.data.element_ID;

    }
    function moveOnElement(event) {
        var str = $('#div_status_window').html();
        $('#div_status_window').html(" <span class='glyphicon glyphicon-arrow-right' aria-hidden='true'></span> " + event.data.element_ID + "(" + event.data.element_type + ")" + str);
    }
    function mouseOutElement(event) {
        $('#div_status_window').html("");
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
    function editElement(event) {
        event.stopPropagation();
        $('#div_edit_window').show(200);
        currentElementID = event.data.element_ID;
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

    }
    function updateDesign() {

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
        $('#div_edit_window').hide();
    }
    function closeEditWindow() {
        event.stopPropagation();
        $('#div_edit_window').hide();
    }
    function dropNewElementTo(event) {
        event.stopPropagation();
        dropNewElement(event, event.data.element_ID);
    }

    function test(event, val) {
        event.stopPropagation();
        alert(val);
    }
    function showEventWindow() {
        $('#div_css_edit_window').hide();
        $('#div_event_edit_window').show();
        $('#li_properties').toggleClass("active");
        $('#li_event').toggleClass("active");

    }
    function showPropertieWindow() {
        $('#div_css_edit_window').show();
        $('#div_event_edit_window').hide();
        $('#li_properties').toggleClass("active");
        $('#li_event').toggleClass("active");
    }
    var xmlElement;
    function savePage() {
        var createdView = "<view>" + $('#canvas').html().replace(/\s\s+/g, "") + "</view>";
        xmlElement = stringToXml(createdView);
        deletedTag = xmlDoc.getElementsByTagName("view")[0];
        xmlDoc.documentElement.removeChild(deletedTag);
        xmlDoc.getElementsByTagName("module")[0].appendChild(xmlElement.getElementsByTagName("view")[0]);
        //xmlDoc.getElementsByTagName("module")[0].appendChild(xmlElement);
        //console.log(xmlDoc.getElementsByTagName("view")[0].childNodes[0].innerHTML);
        console.log(xmlDoc);
        var postXMLDoc = xmlToString(xmlDoc);
        $.getJSON("<?php echo base_url('index.php/Main/savePage') ?>", {xml:postXMLDoc,page_ID:<?php echo $page_detail['page_data'][0]->page_ID ?>}, savePageResult);
    }
    function savePageResult(json) {
        if (json[0] == 1) {                 // save page complete
            alert('sucess');
        }
    }
<?php if (isset($page_detail['page_xml'])) { ?>
        createFromXMLObject();
        function createFromXMLObject() {
            xmlDoc = stringToXml('<?php echo $page_detail["page_xml"] ?>');
        }
<?php } else { ?>
        createNewXMLObject();
        function createNewXMLObject() {
            txt = "<module>";
            txt += "<detail>";
            txt += "<name><?php echo $page_ID ?></name>";
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
    function xmlToString(thexml) {
        if (thexml.xml) {

            xmlString = thexml.xml;
        } else {

            xmlString = (new XMLSerializer).serializeToString(thexml);
        }
        return xmlString;
    }
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
</script>

