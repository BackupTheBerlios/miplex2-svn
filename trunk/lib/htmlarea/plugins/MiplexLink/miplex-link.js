// Character Map plugin for HTMLArea
// Sponsored by http://www.systemconcept.de
// Implementation by Holger Hees based on HTMLArea XTD 1.5 (http://mosforge.net/projects/htmlarea3xtd/)
// Original Author - Bernhard Pfeifer novocaine@gmx.net 
//
// (c) systemconcept.de 2004
// Distributed under the same terms as HTMLArea itself.
// This notice MUST stay intact for use (see license.txt).
function MiplexLink(editor) {
    this.editor = editor;

    var cfg = editor.config;
	var toolbar = cfg.toolbar;
	var self = this;
	var i18n = InsertFile.I18N;
        
	cfg.registerButton({
                id       : "miplexlink",
                tooltip  : i18n["MiplexLinkTooltip"],
                image    : editor.imgURL("insert-file.gif", "MiplexLink"),
                textMode : false,
                action   : function(editor) {
                                self.buttonPress(editor);
                           }
            })

	/*var a, i, j, found = false;
	for (i = 0; !found && i < toolbar.length; ++i) {
		a = toolbar[i];
		for (j = 0; j < a.length; ++j) {
			if (a[j] == "inserthorizontalrule") {
				found = true;
				break;
			}
		}
	}
	if (found)
	    a.splice(j, 0, "miplexlink");
        else{                
            toolbar[1].splice(0, 0, "separator");
	    toolbar[1].splice(0, 0, "miplexlink");
        }*/
};

MiplexLink._pluginInfo = {
	name          : "MiplexLink",
	version       : "0.1",
	developer     : "Martin Grund",
	developer_url : "http://grundprinzip.de",
	c_owner       : "Martin Grund",
	sponsor       : "",
	sponsor_url   : "",
	license       : "htmlArea"
};

MiplexLink.prototype.buttonPress = function(editor) {

	var sel = editor._getSelection();
	var range = editor._createRange(sel);
	var outparam = null;
	var manager = _editor_url + 'plugins/MiplexLink/miplex_link.php';

	Dialog(manager, 
    
        function(param) {
    		if (!param) {	// user must have pressed Cancel
    			return false;
    		}
        	var doc = editor._doc;
        	
        	var insertText = "<a href='"+ param['link'] +"' title='"+ param['title'] +"'>" + range + "</a>";
    
        	editor.insertHTML(insertText);
        		
        	},
        outparam);

}

