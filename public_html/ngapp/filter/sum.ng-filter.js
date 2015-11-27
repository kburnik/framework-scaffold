app

.filter('sum', function() {
  return function(items, field) {
    if (!items)
      return 0;

    var sum = 0;
    for (var i in items)
      sum += items[i][field];

    return sum;
  }
});