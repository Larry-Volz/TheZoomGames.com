// generate iframe
var gamePanel = document.getElementsByClassName('gamePanel')[0]
var iframe = document.createElement('iframe')
iframe.style.border='none'
iframe.style.padding=0
iframe.style.margin=0
iframe.style.width='100%'
iframe.style.height='100%'
iframe.src='awesome-zoom/public/index.html'
gamePanel.innerText=''
gamePanel.append(iframe)