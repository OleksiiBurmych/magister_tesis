(function ($) {
  var postsArray = Object.entries(posts);
  var sptpTinyMceValue = [];
  function sptpTinyMceFunc(editor) {
    for (const [id, title] of postsArray) {
      var obj = Object.assign({
        text: title,
        onClick: function () {
          editor.insertContent('[wpteam id="' + id + '"]');
        }
      });
      sptpTinyMceValue.unshift(obj);
    }
    return sptpTinyMceValue;
  }

  tinymce.PluginManager.add("sptp_tinymce_button", function (editor, url) {
    editor.addButton("sptp_tinymce_button", {
      text: "WP Team",
      classes: "sptp_tinymce_button_icon",
      type: "listbox",
      fixedWidth: true,
      values: sptpTinyMceFunc(editor)
    });
  });
})();
