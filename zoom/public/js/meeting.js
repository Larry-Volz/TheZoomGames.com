// import { ZoomMtg } from "./node_modules/@zoomus/websdk"

// For CDN version default
ZoomMtg.setZoomJSLib('https://dmogdx0jrul3u.cloudfront.net/1.8.3/lib', '/av')

// For Global use source.zoom.us:
// ZoomMtg.setZoomJSLib('https://source.zoom.us/1.8.3/lib', '/av')

// In China use jssdk.zoomus.cn:
// ZoomMtg.setZoomJSLib('https://jssdk.zoomus.cn/1.8.3/lib', '/av')

ZoomMtg.preLoadWasm()
ZoomMtg.prepareJssdk()
joinMeeting(parseQuery())
function joinMeeting(data)
{
  if (data.china)
    ZoomMtg.setZoomJSLib("https://jssdk.zoomus.cn/1.8.3/lib", "/av")
  ZoomMtg.init({                        //CONFIGURATION VARIABLES FROM THE LAUNCHMEETING FUNCTION
    leaveUrl: './thanks.html',
    isSupportAV: true,
    success: function() {
      // ZoomMtg.join(data)
      console.log('meeting.js|joinMeeting()->ZoomMtg.init({success:()})')
      console.log(data)
      $.i18n.reload(data.lang)
      ZoomMtg.join({
        signature: data.signature,
        apiKey: data.apiKey,
        meetingNumber: data.meetingNumber,
        userName: data.userName,
        passWord: data.password,
        error: function(res) {
          console.clear()
          console.log('ZoomMtg.join({error:()})')
          console.log(data)
          removeDivPhone()
        },
        success: function(res) {
          console.clear()
          console.log('ZoomMtg.join({success:()})')
          console.log(data)
          removeDivPhone()
        }
      })
    }
  })
}

function removeDivPhone()
{
  var foo = setInterval(function()
  {
    if ($(document).find('div#phone').remove())
    {
      clearInterval(foo)
    }
  },1000)
}

function parseQuery () {
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
}
