// generate iframe
var gamePanel = document.getElementsByClassName('gamePanel')[0]
var iframe = document.createElement('iframe')
iframe.style.border='none'
iframe.style.padding=0
iframe.style.margin=0
iframe.style.width='100%'
iframe.style.height='100%'
// iframe.src='awesome-zoom/public/index.html'
iframe.id='zoom-iframe'
window.zoomflag = false

var tool = {
  serialize:function(arr) {
    var ret = ''
    for (var k in arr)
      ret += k + '=' + arr[k] + '&'
    return ret.slice(0, -1)
  }
}

// trying to fix 'div.gamePanel' height.
$(document).ready(function() {
  // return false
  var style = '<style>'
  style += 'body{display:flex;flex-flow:column;height:100vh;}'
  // style += 'div.container-fluid{flex:1 1 auto;}'
  // style += 'section,div.container-fluid,div.container-fluid > div.row,'
  style += 'div.container-fluid > div.row > div.gamePanel{flex:1 1 auto;}'
  style += '</style>'
  $(document).find('head').append(style)
})

$(document).on('click', '.card-body', function() {
  if (window.zoomflag === true)
    return false
  window.zoomflag = true
  var signendpoint = './signature'
  var meetinghtml = 'awesome-zoom/public/meeting.html?'
  var data = {}
  var foo = {}
  data.meetingNumber = 86002890126
  data.role = 1
  foo.pwd = 'GFuk5a';
  foo.role = data.role
  foo.lang = 'en-US'
  foo.china = 0
  foo.mn = data.meetingNumber
  foo.name = 'lio';
  foo.email = '';

  if (typeof $.ajax !== 'undefined')
  {
    $.ajax({
      url: signendpoint,
      type: 'post',
      data: data,
      success: function(res) {
        gamePanel.innerText=''
        gamePanel.append(iframe)
        foo.apiKey = res.apiKey
        foo.signature = res.signature
        var src = meetinghtml + tool.serialize(foo)
        $(document).find('#zoom-iframe').attr('src', src)
        window.zoomflag = false
      },
      error: function(res) {
        console.log(res)
      }
    })
  } else {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var res = JSON.parse(xhttp.response)
        gamePanel.innerText=''
        gamePanel.append(iframe)
        foo.apiKey = res.apiKey
        foo.signature = res.signature
        var src = meetinghtml + tool.serialize(foo)
        $(document).find('#zoom-iframe').attr('src', src)
        window.zoomflag = false
      }
    };
    xhttp.open('POST', signendpoint, true);
    var d = new FormData();
    for (var k in data)
      d.append(k, data[k]);
    xhttp.send(d);
  }
  // ajax request
})
