// import { ZoomMtg } from "./node_modules/@zoomus/websdk"

// For CDN version default
ZoomMtg.setZoomJSLib('https://dmogdx0jrul3u.cloudfront.net/1.8.3/lib', '/av')

// For Global use source.zoom.us:
// ZoomMtg.setZoomJSLib('https://source.zoom.us/1.8.3/lib', '/av')

// In China use jssdk.zoomus.cn:
// ZoomMtg.setZoomJSLib('https://jssdk.zoomus.cn/1.8.3/lib', '/av')

ZoomMtg.preLoadWasm()
ZoomMtg.prepareJssdk()
joinMeeting(testTool.parseQuery())
function joinMeeting(gmc)
{
    ZoomMtg.init({
        leaveUrl: './thanks.html',
        isSupportAV: true,
        success: function() {
            toggleBox()
            ZoomMtg.join({
                signature: gmc.signature,
                apiKey: gmc.apiKey,
                meetingNumber: gmc.mn,
                userName: gmc.name,
                passWord: gmc.pwd,
                error: function(res) {
                    console.clear()
                    // console.log(res)
                    removeDivPhone()
                },
                success: function(res) {
                    console.clear()
                    // console.log(res)
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
        console.log('foo')
    },1000)
}