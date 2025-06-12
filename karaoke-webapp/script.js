$(function() {
  $('#queue').sortable({
    update: function() {
      var order = $(this).sortable('toArray', {attribute: 'data-id'});
      $.post('index.php', {order: order});
    }
  });
});
