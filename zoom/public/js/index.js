var zoom = {
  game: null,
  window: null,
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
  session_key: 'awesomezoom',
  urls_meetinghtml: 'zoom/public/meeting.html?',
  /* apis */
  urls_querylangs: './queryLangs',
  urls_getuser: './getUser',
  urls_startzoom: './startZoom',

  urls_setname: './setName',
  /* apis */
  selectors: function() {
    return [
      '#jeopardy-game',
      '#chess-game',
      '#checkers-game',
      '#connect4-game'
    ].toString()
  },
  zoomflagToggle: function() {
    zoom.zoomflag = !zoom.zoomflag
    return zoom.zoomflag
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
  start: function()
  {
    zoom.queryLangs()
    $(document).on('mousedown', zoom.selectors(), function(e) {
      if (zoom.zoomflag === true)
        return true
      // console.log('mousedown here')
      console.clear()
      zoom.game = $(this).attr('id')
      zoom.bg_color = $(this).css('background-color')
      zoom.color = $(this).css('color')
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
    zoom.iframe.style.border='none'
    zoom.iframe.style.padding=0
    zoom.iframe.style.margin=0
    zoom.iframe.style.width='100%'
    zoom.iframe.style.height='100%'
    zoom.iframe.id='zoom-iframe'
    return zoom.iframe
  },
  appendIframe: function() {
    zoom.genIframe()
    var foo = document.getElementsByClassName('gamePanel')[0]
    foo.innerText=''
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
  loadingDialog:function() {
    if (!zoom.userInfo.name)
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
        zoom.callZoom()
      }
    })
  },
  createDialog: function() {
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
    // hl += '    .azf-button button{margin-left:10px;}'
    hl += '    #azf-cancle{margin-left:10px;}'
    hl += '    #azflang option{text-align:justify;text-justify: inter-word;}'
    // hl += '    #azflang option::after{width:100%;content:"";display:inline-block;}'
    // hl += '    #azflang,label[for="azflang"],#azf-submit{display:none;}'
    hl += '  </style>'
    hl += '  <div class="azf-box shadow rounded">'
    hl += '    <h5 class="azf-color card-body">Some step...</h5>'
    hl += '    <div class="azf-input card-body">'
    hl += '      <label for="azflang" class="azf-color">'
    hl += '        <h3><b style="color:red;">*</b> <b>Set Zoom Language</b></h3>'
    hl += '      </label>'
    hl += '      <select id="azflang" name="azflang" required></select>'
    hl += '    </div>'
    // hl += '    <div class="azf-button card-body">'
    // hl += '      <input class="azf-color" type="submit" id="azf-submit">'
    // hl += '      <input class="azf-color" type="button" id="azf-cancle" value="Cancle">'
    // hl += '    </div>'
    hl += '    <div class="azf-button card-body">'
    hl += '      <button id="startZoom">Start Zoom</button>'
    hl += '    </div>'
    hl += '  </div>'
    hl += '</div>'
    if (!$('#zoom-form').length)
      $('div.container-fluid').append(hl).css({position:'relative'})
    $('#azf-cancle').on('click', function() {
      zoom.removeDialog()
      return false
    })
    $('#startZoom').on('click', function() {
      zoom.startZoom()
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
      }
      zoom.langs = res
      localStorage.setItem('zoomLangs', JSON.stringify(res))
    })
  },
  startZoom: function() {
    $('#startZoom').attr('disabled', true).text('Waiting...')
    var res = null
    var xhr = new XMLHttpRequest()
    xhr.onreadystatechange = function(e) {
      if ((xhr.readyState !== 3) && (xhr.readyState !== 4))
        return false
      if (xhr.response)
        res = JSON.parse(xhr.response)
      if ((xhr.readyState === 4) && (xhr.status === 200)) {
        zoom.lunchMeeting(res)
      }

      if ((xhr.status === 1010) && (xhr.readyState === 3)) {
        zoom.getAccessToken(res.errorMessage.url)
        delete xhr
      }
    }
    xhr.open('POST', zoom.urls_startzoom, true)
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
    xhr.send(zoom.xhrData({lang: localStorage.getItem('zoomLang')}))
  },
  lunchMeeting: function(config) {
    zoom.appendIframe()
    config.lang = localStorage.getItem('zoomLang')
    var src = zoom.urls_meetinghtml + zoom.serialize(config)
    $(document).find('#zoom-iframe').attr('src', src)
    zoom.changeGamePanelStyle()
    zoom.removeDialog()
    $('#'+zoom.game).click()
  }
}



$(document).ready(function() {
  zoom.start()
})
