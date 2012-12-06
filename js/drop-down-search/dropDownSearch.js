
  $(function() {
    $('.editable-select').editableSelect(
      {
        bg_iframe: true,
        onSelect: function(list_item) {
          $('#results').html('List item text: '+ list_item.text() +'<br> \
          Input value: '+ this.text.val());
        }
      }
    );
    var select = $('.editable-select:first');
    var instances = select.editableSelectInstances();
    instances[0].addOption('Germany, value added programmatically');
  });
  if(!window.console || !window.console.log || !$.browser.mozilla) {
    window.console = {};
    window.console.log = function(str) { $('#debug').show().val($('#debug').val() + str +'\n'); };
  }
  var hidden_offset;
  function moveHidden() {
    var hidden = $('#hidden');
    hidden.show();
    $('#toggle_hidden').val('Hide');
    if(!hidden_offset) {
      hidden_offset = hidden.offset();
      hidden
        .css('position', 'absolute')
        .css('top', hidden_offset.top)
        .css('left', hidden_offset.left)
        .animate({top: 100, left: 400})
      ;
    } else {
      hidden.animate({top: hidden_offset.top, left: hidden_offset.left}, function() {
        hidden.css('position', 'static');
        hidden_offset = null;
      });
    }
  }
  function toggleHidden(btn) {
    var hidden = $('#hidden');
    if($('#hidden').is(':visible')) {
      hidden.hide();
      $(btn).val('Display');
    } else {
      hidden.show();
      $(btn).val('Hide');
    }
  }