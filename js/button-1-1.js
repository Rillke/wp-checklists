// JavaScript Document

function getBaseURL () {
   return location.protocol + '//' + location.hostname + 
      (location.port && ':' + location.port) + '/';
}

(function() {
    tinymce.create('tinymce.plugins.wpcl_button', {
        init : function(ed, url) {
            ed.addButton('wpcl_button', {
                title : 'Checkliste',image : url+'/icons/circle-ok.png',onclick : function() {
                     ed.selection.setContent('<div class="wpcl-checklist">' + ed.selection.getContent() + '</div>');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('wpcl_button', tinymce.plugins.wpcl_button);
})();
