var awesome_zoom = {
  userInfo: {name: null},
  iframe: null,
  bg_color: null,
  color: null,
  zoomflag: false,
  session_key: 'awesomezoom',
  urls_signature: './index.php/signature',
  urls_meetinghtml: 'awesome-zoom/public/meeting.html?',
  /* apis */
  urls_getuser: './getUser',
  urls_setname: './setName',
  urls_requesttoken: './requestToken',
  urls_refreshtoken: './refreshToken',
  urls_createmeeting: './createMeeting',
  urls_match: './match',
  urls_joinmeeting: './joinMeeting',
  /* apis */
  selectors: function() {
    return [
      '#jeopardy-game',
      '#chess-game',
      '#checkers-game',
      '#connect4-game'
    ]
    .toString()
  },
  getAccessToken: function() {
    // window.open(awesome_zoom.urls_requesttoken+'?name='+name, '', '_blank')
    window.open(awesome_zoom.urls_requesttoken, '', '_blank')
  },
  start: function()
  {
    // console.log('console.log($.cookie()):')
    // console.log($.cookie())
    awesome_zoom.getUser()
    $(document).on('mousedown', awesome_zoom.selectors(), function(e) {
      console.log('mousedown here')
      awesome_zoom.bg_color = $(this).css('background-color')
      awesome_zoom.color = $(this).css('color')
      // ask name.
      awesome_zoom.askName()
      // call zoom.
      // awesome_zoom.callZoom()
      // $(this).click()
    })
  },
  getUser: function() {
    var foo = {}
    if ($.cookie(awesome_zoom.session_key))
      foo[awesome_zoom.session_key] = $.cookie(awesome_zoom.session_key)
    $.ajax({
      url: awesome_zoom.urls_getuser,
      type: 'post',
      data: foo,
      success: function(res) {
        $.cookie('userInfo', JSON.stringify(res))
        awesome_zoom.userInfo = res
        if (res.session_id == $.cookie(awesome_zoom.session_key))
          return true
        $.cookie(awesome_zoom.session_key, res.session_id)
      }
    })
  },
  register: function() {
    $.ajax({url:awesome_zoom.urls_register})
  },
  genIframe: function() {
    awesome_zoom.iframe = document.createElement('iframe')
    awesome_zoom.iframe.style.border='none'
    awesome_zoom.iframe.style.padding=0
    awesome_zoom.iframe.style.margin=0
    awesome_zoom.iframe.style.width='100%'
    awesome_zoom.iframe.style.height='100%'
    awesome_zoom.iframe.id='zoom-iframe'
    return awesome_zoom.iframe
  },
  appendIframe: function() {
    awesome_zoom.genIframe()
    var foo = document.getElementsByClassName('gamePanel')[0]
    foo.innerText=''
    foo.append(awesome_zoom.iframe)
  },
  serialize: function(arr) {
    var ret = []
    for (var k in arr)
      ret.push(k + '=' + arr[k])
    return ret.join('&')
  },
  changeGamePanelStyle: function() {
    // trying to fix 'div.gamePanel' height and width.
    $(document).ready(function() {
      var style = '<style>'
      style += 'body{display:flex;flex-flow:column;height:100vh;}'
      // style += 'div.container-fluid{flex:1 1 auto;}'
      // style += 'section,div.container-fluid,div.container-fluid > div.row,'
      style += 'div.container-fluid>div.row>div.gamePanel'
      style += '{flex:1 1 auto;padding:5px;min-height:530px;min-width:450px;}'
      style += '</style>'
      $(document).find('head').append(style)
    })
  },
  askName: function() {
    $(document).ready(function() {
      awesome_zoom.createDialog()
      awesome_zoom.submitName()
      // awesome_zoom.loadingDialog()
    })
  },
  loadingDialog:function() {
    if (!awesome_zoom.userInfo.name)
      return false
    $('.azf-input,.azf-button').remove()
    $('.azf-box h1').text('loading...').css({
      height: '100%',
      'line-height': $('.azf-box form').css('height')
    })
    return false
    $.ajax({
      url: '/find match',
      success: function(res) {
        awesome_zoom.callZoom()
      }
    })
  },
  createDialog: function() {
    var bg_color = awesome_zoom.bg_color
    var color = awesome_zoom.color
    var hl = '<div style="left:0;top:0;height:100%;width:100%;position:absolute;" class="azf" id="awesome-zoom-form">'
    hl += '<style>div.azf>div.azf-box>form{height:100%;width:100%;}'
    hl += 'div.azf .azf-color{color:' + color + ';}'
    hl += 'div.azf>div.azf-box{position:absolute;padding:20px;}'
    hl += 'div.azf>div.azf-box{left:20%;top:25%;width:60%;height:50%;}'
    hl += 'div.azf>div.azf-box{border-radius:1rem!important;}'
    hl += 'div.azf>div.azf-box{background:' + bg_color + ';}'
    hl += 'div.azf-input label[for="azfname"]{padding-right:10px;}'
    hl += 'div.azf-button>input[type="button"]{margin-left:10px;}'
    hl += '</style><div class="azf-box shadow rounded"><form onsubmit="return false">'
    hl += '<h1 class="azf-color card-body">Who are you?</h1>'
    hl += '<div class="azf-input card-body"><div>'
    hl += '<label for="azfname" class="azf-color"><b style="color:red;">*</b>'
    hl += '<b>Name</b></label><div style="position:relative;display:inline-block">'
    hl += '<div id="azf-tips" style="display:none;"> Name required!</div>'
    hl += '<input id="azfname" type="text" name="azfname" required></div>'
    hl += '</div></div><div class="azf-button card-body">'
    hl += '<input class="azf-color" type="submit" id="azf-submit">'
    hl += '<input class="azf-color" type="button" id="azf-cancle" value="Cancle">'
    hl += '</div></form></div></div>'
    if (!$('#awesome-zoom-form').length)
      $('div.container-fluid').append(hl).css({position:'relative'})
    $('#azf-cancle').on('click', function() {
      awesome_zoom.removeDialog()
    })
    $(document).on('click keydown', '#azfname,#azf-tips', function() {
      awesome_zoom.validationTips(1)
      $('#azfname').focus()
    })
  },
  validationTips: function(val) {
    $('#azf-tips').css({
      left: '5px',
      color: 'red',
      height:'100%',
      position:'absolute',
      'line-height':'30px',
      'font-weight': 'bolder',
    })
    if (val)
      $('#azf-tips').hide()
    else
      $('#azf-tips').show()
  },
  removeDialog: function() {
    $('#awesome-zoom-form').remove()
    $('div.container-fluid').removeAttr('style')
    awesome_zoom.zoomflag = false
  },
  submitName: function() {
    $('#azf-submit').on('mousedown', () => {
      var name = $('input[name="azfname"]').val()
      if (!name)
        return awesome_zoom.validationTips(name)
      awesome_zoom.removeDialog()
      $.ajax({
        url: awesome_zoom.urls_setname,
        type: 'post',
        data: {name: name},
        success: function(res) {
          awesome_zoom.getAccessToken()
        },
        error: function(res) {
          awesome_zoom.getAccessToken()
          // alert(res.responseJSON.errorMessage)
        }
      })
    })
  },
  callZoom: function() {
    awesome_zoom.zoomflag = true
    var data = {}
    var foo = {}
    data.meetingNumber = 86002890126
    data.role = 1
    foo.pwd = 'GFuk5a'
    foo.role = data.role
    foo.lang = 'en-US'
    foo.china = 0
    foo.mn = data.meetingNumber
    foo.name = 'lio'
    foo.email = ''

    if (typeof $.ajax !== 'undefined') {
      $.ajax({
        url: awesome_zoom.urls_signature,
        type: 'post',
        data: data,
        success: function(res) {
          awesome_zoom.appendIframe()
          foo.apiKey = res.apiKey
          foo.signature = res.signature
          var src = awesome_zoom.urls_meetinghtml + awesome_zoom.serialize(foo)
          $(document).find('#zoom-iframe').attr('src', src)
          awesome_zoom.zoomflag = false
        },
        error: function(res) {
          console.log(res)
        }
      })
    } else {
      var xhttp = new XMLHttpRequest()
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var res = JSON.parse(xhttp.response)
          awesome_zoom.appendIframe()
          foo.apiKey = res.apiKey
          foo.signature = res.signature
          var src = awesome_zoom.urls_meetinghtml + awesome_zoom.serialize(foo)
          $(document).find('#zoom-iframe').attr('src', src)
          awesome_zoom.zoomflag = false
        }
      }
      xhttp.open('POST', awesome_zoom.urls_signature, true)
      var d = new FormData()
      for (var k in data)
        d.append(k, data[k])
      xhttp.send(d)
    }
  }
}

awesome_zoom.start()

// elem.on('event',function(e)
// {
//   e.stopPropagation()
//   goDoSomething(function(){
//     elem.parent().trigger(e)
//   })
// })

// $(document).on('click', awesome_zoom.selectors(), function(e) {
//   if (awesome_zoom.zoomflag === true)
//     return false
//   awesome_zoom.zoomflag = true
//   // $(awesome_zoom.selectors()).each(function(k,v) {
//   //   console.log(jQuery._data($(v)[0], 'events'))
//   // })
//   // e.stopPropagation()
//   // e.preventDefault()
//   // e.stopPropagation()
//   // e.stopImmediatePropagation()
//   // $(this).trigger(e)
//   // console.log(e)
//   e.preventDefault()
//   //
//   return false
// })
