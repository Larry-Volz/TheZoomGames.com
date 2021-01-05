var zoom = {
  game: null,
  window: null,
  meetingId: null,
  joinConfig: null,
  matchClearInterval: null,
  matchClearTimeout: null,
  matchTimeout: 60,
  matchFrequency: 1000,
  langs: null,
  lang: null,
  userInfo: {name: null},
  iframe: null,
  bg_color: null,
  color: null,
  zoomflag: false,
  zoomdoublegetuserflag: false,
  session_key: 'awesomezoom',
  urls_meetinghtml: 'zoom/public/meeting.html?',   //URL'S FOR VARIOUS THINGS
  /* apis */
  urls_querylangs: 'https://www.thezoomgames.com/queryLangs',
  urls_getuser: 'https://www.thezoomgames.com/getUser',
  urls_startzoom: 'https://www.thezoomgames.com/startZoom',

  urls_setname: 'https://www.thezoomgames.com/setName',
  /* apis */
  selectors: function() {
    return [
      '#jeopardy-game', 
      '#chess-game',
      '#checkers-game',      //EVENT LISTENER SELECTORS FOR GAME BUTTONS
      '#connect4-game'
    ].toString()
  },
  zoomflagCheck: function(val) {
    if (zoom.zoomflag === true)
      return false
    zoom.zoomflag = val
  },
  xhrData: function(data) {
    var d = new FormData()
    for (var k in data)
      d.append(k, data[k])
    return d
  },
  getAccessToken: function(url) {
    var u = zoom.urls_requesttoken
    if (url)
      u = url
    // zoom.window = window.open(url, '', '_blank')
    window.open(url, '', '_blank')
  },
  assignment: function(id) {
    zoom.game = $('#'+id).attr('id')
    zoom.bg_color = $('#'+id).css('background-color')
    zoom.color = $('#'+id).css('color')
  },
  runOnce: function() {
    zoom.queryLangs()
    $(document).on('mousedown', zoom.selectors(), function(e) {  //EVENT LISTENER FOR BUTTONS 
      // console.log('mousedown here')
      if (zoom.zoomdoublegetuserflag === true)
        return true
      zoom.zoomdoublegetuserflag = true

      zoom.assignment($(this).attr('id'))
      console.clear()
      zoom.getUser()
      zoom.createDialog()
    })
  },
  getUser: function() {
    var foo = {}
    if ($.cookie(zoom.session_key))
      foo[zoom.session_key] = $.cookie(zoom.session_key)
    $.ajax({
      url: zoom.urls_getuser,
      type: 'post',
      data: foo,
      success: function(res) {
        $.cookie('userInfo', JSON.stringify(res))
        zoom.userInfo = res
        if (res.session_id == $.cookie(zoom.session_key))
          return true
        $.cookie(zoom.session_key, res.session_id)
      }
    })
  },
  genIframe: function() {
    if (zoom.iframe !== null)
      return zoom.iframe
    zoom.iframe = document.createElement('iframe')
    zoom.iframe.style.border = 'none'
    zoom.iframe.style.padding = 0
    zoom.iframe.style.margin = 0
    zoom.iframe.style.width = '100%'
    zoom.iframe.style.height = '100%'
    zoom.iframe.id = 'zoom-iframe'
    return zoom.iframe
  },
  appendIframe: function() {  //WHERE APPENDING THE IFRAME WHERE THE OLD PICTURE WAS
    zoom.genIframe()
    var foo = document.getElementsByClassName('gamePanel')[0]
    foo.innerText = ''
    foo.append(zoom.iframe)
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
  createDialog: function(askName=false) { //CREATING DIALOG POP-UP MODAL ASKING FOR START OF GAME
    var bg_color = zoom.bg_color
    var color = zoom.color
    var hl = '<div style="left:0;top:0;height:100%;width:100%;position:absolute;" class="azf" id="zoom-form">'
    hl += '  <style>'
    hl += '    div.azf .azf-color{color:' + color + ';}'
    hl += '    div.azf-box{background:' + bg_color + ';}'
    hl += '    div.azf-box{position:absolute;padding:20px;}'
    hl += '    div.azf-box{left:20%;top:25%;width:60%;height:60%;}'
    hl += '    div.azf-box{border-radius:1rem!important;}'
    hl += '    div.azf-input label[for="azflang"]{padding-right:10px;}'
    hl += '    div.azf-input label[for="azfname"]{padding-right:10px;}'
    hl += '    .azf-button button{margin-left:10px;}'
    hl += '    #azfsubmit{display:none;}'
    hl += '    #azflang option{text-align:justify;text-justify: inter-word;}'
    hl += '  </style>'
    hl += '  <div class="azf-box shadow rounded">'
    hl += '    <h5 class="azf-color card-body">Sign in to Zoom</h5>'
    hl += '    <form id="azfform" onsubmit="javascript:return false">'

    if (askName) {
      hl += '      <style>div.azf-box{height:80%;top:10%;}</style>'
      hl += '      <div class="azf-input card-body">'
      hl += '        <div>'
      hl += '          <label for="azfname" class="azf-color">'
      hl += '            <h3><b style="color:red;">*</b> <b>Set Your Name</b></h3>'
      hl += '          </label>'
      hl += '        </div>'
      hl += '        <div>'
      hl += '          <input id="azfname" required type="text" placeholder="what\'s your name" />'
      hl += '        <div>'
      hl += '      </div>'
    }

    // hl += '      <div class="azf-input card-body">'
    // hl += '        <div>'
    // hl += '          <label for="azflang" class="azf-color">'
    // hl += '            <h3><b style="color:red;">*</b> <b>Set Zoom Language</b></h3>'
    // hl += '          </label>'
    // hl += '        </div>'
    // hl += '        <div>'
    // hl += '          <select id="azflang" name="azflang" required></select>'
    // hl += '        </div>'
    // hl += '      </div>'
    hl += '      <div class="azf-button card-body">'
    hl += '        <input type="submit" id="azfsubmit">'
    hl += '        <button id="deleteJoin">[JWT] JOIN</button>'  //ACTUAL JOIN BUTTON THAT IS LISTENED FOR ELSEWHERE #deleteJoin
    hl += '        <button id="startZoom">Start Zoom</button>'
    hl += '        <button id="azf-cancle">Cancel</button>'
    hl += '      </div>'
    hl += '    </form>'
    hl += '  </div>'
    hl += '</div>'
    if (!$('#zoom-form').length)
      $('div.container-fluid').append(hl).css({position:'relative'})
    $('#azf-cancle').on('click', function() {
      zoom.removeDialog()
      return false
    })
    //FORM VALIDATION
    $('#startZoom').on('click', function() {
      $('#azfsubmit').click()
      $('#azfform').submit(function() {
        if (zoom.zoomflag)
          return false
        zoom.zoomflag = true

        zoom.startZoom()   //**************** START ZOOM **********************
        return false
      })
    })
    $('#deleteJoin').on('click', function() {  //EVENT LISTENER FOR THE POP-UP MODAL BOX
      $('#azfsubmit').click()
      $('#azfform').submit(function() {
        if (zoom.zoomflag)
          return false
        zoom.zoomflag = true

        zoom.startZoom(true)
        return false
      })
    })
    zoom.renderLangs()
    zoom.changeLang()
  },
  removeDialog: function() {
    $('#zoom-form').remove()
    $('div.container-fluid').removeAttr('style')
    zoom.zoomflag = false
  },
  changeLang: function() {
    zoom.lang = $('#azflang').val()
    localStorage.setItem('zoomLang', zoom.lang)
    $('#azflang').on('change', function(){
      zoom.lang = $(this).val()
      localStorage.setItem('zoomLang', zoom.lang)
    })
  },
  renderLangs: function() {
    if ($('#azflang').length)
      $('#azflang').html(localStorage.getItem('zoomLangsHtml'))
  },
  queryLangs: function() {
    if (zoom.langs !== null)
      return true
    if (localStorage.getItem('zoomLangs'))
      zoom.langs = JSON.parse(localStorage.getItem('zoomLangs'))
    $.get(zoom.urls_querylangs, null, function(res) {
      if (res) {
        var html = ''
        for (k in res)
          if (k == 'en-us')
            html += '<option selected value="'+k+'">'+res[k]+'</option>'
          else
            html += '<option value="'+k+'">'+res[k]+'</option>'
        localStorage.setItem('zoomLangsHtml', html)
        zoom.renderLangs()
      }
      zoom.langs = res
      localStorage.setItem('zoomLangs', JSON.stringify(res))
    })
  },
  
  //DOES API CALL TO CONNECT TO ZOOM SDK
  startZoom: function(deleteJoin) {
    $('#startZoom').attr('disabled', true).text('Waiting...')
    var res = null
    var xhr = new XMLHttpRequest()
    var data = {lang: localStorage.getItem('zoomLang')}
    if (zoom.joinConfig.meetingId)
      data.meetingId = zoom.joinConfig.meetingId
    if ($('#azfname').length)
      data.name = $('#azfname').val()
    if (deleteJoin)
      data.DELETEJOIN = deleteJoin
    xhr.onreadystatechange = function(e) {
      if ((xhr.readyState !== 3) && (xhr.readyState !== 4))
        return false
      if (xhr.response)
        res = JSON.parse(xhr.response)
      if ((xhr.readyState === 4) && (xhr.status === 200)) {
        zoom.lunchMeeting(res)  //LAUNCHING ZOOM MEETING
      }

      if ((xhr.status === 1010) && (xhr.readyState === 3)) {
        zoom.getAccessToken(res.errorMessage.url)
        delete xhr
      }
    }
    xhr.open('POST', zoom.urls_startzoom, true)
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
    xhr.send(zoom.xhrData(data))
  },
  lunchMeeting: function(config) {
    zoom.appendIframe()
    config.lang = localStorage.getItem('zoomLang')
    zoom.meetingId = config.meetingNumber
    var src = zoom.urls_meetinghtml + zoom.serialize(config)
    $(document).find('#zoom-iframe').attr('src', src)
    zoom.changeGamePanelStyle()
    zoom.removeDialog()
    $('#'+zoom.game).click()
    zoom.shareLink()
  },
  shareLink: function() {
    var hl = '<div _style="position:absolute;">'
    hl += '<style>'
    hl += '#azf-share{position:absolute;top:-.9rem;left:.3rem;}'
    hl += '</style>'
    hl += '<button id="azf-share">share</button>'
    hl += '</div>'
    var foo = document.getElementsByClassName('gamePanel')[0]
    $(foo).css({position:'relative'}).append(hl)
    $('#azf-share').click(function() {
      var link = location.href + '?' + zoom.serialize({
        meetingId: zoom.meetingId,
        game: zoom.game
      })
      zoom.copyToClipboard(link)
    })
  },
  copyToClipboard: function(text) {
    console.log(text)
    var del = document.createElement('input')
    del.id = 'azf-del'
    del.value = text
    $('#azf-share').append($(del))
    $('#azf-del').select()
    document.execCommand('copy')
    $('#azf-del').remove()
  },
  parseQuery: function() {
    return (function () {
      var href = window.location.href
      var queryString = href.substr(href.indexOf("?"))
      var query = {}
      var pairs = (queryString[0] === "?"
        ? queryString.substr(1)
        : queryString
      ).split("&")
      for (var i = 0; i < pairs.length; i += 1) {
        var pair = pairs[i].split("=")
        query[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1] || "")
      }
      return query
    })()
  },
  beforeStart: function() {
    zoom.joinConfig = zoom.parseQuery()
    if (!zoom.joinConfig.game || !zoom.joinConfig.meetingId)
      return zoom.runOnce()
    zoom.queryLangs()
    zoom.assignment(zoom.joinConfig.game)
    zoom.getUser()
    zoom.createDialog(true)
    return false
    $.ajax({
      url: '',
      data: zoom.joinConfig,
      success: function(res) {
        console.log(res)
      }
    })
  }
}



$(document).ready(function() {
  zoom.beforeStart()
  zoom.runOnce()
})
