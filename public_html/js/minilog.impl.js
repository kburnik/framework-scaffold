$(function(){
  Minilog
   .enable()
   .pipe(new Minilog.backends.jQuery({
        url: '/api/Debug/@log',
        interval: 2000
        }));

  window.log = Minilog('app');
})
