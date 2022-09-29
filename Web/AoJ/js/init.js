var pusher = new Pusher('1606ea21cf9654d0a228', {
    cluster: 'ap3'
})


let court_main = pusher.subscribe('court-main')
court_main.bind('add', data => {
    let title = data.title
    let content = data.content
    let defendant = data.defendant
    let delator = data.delator
    let deadline = data.deadline
    let defendant_point = data.defendant_point
    let delator_point = data.delator_point
    let idx = data.idx
    let flag = parseInt(data.flag)

    if(flag){
        $('.court-main').prepend(`<div onClick="toDetail(${idx}, 1)" class="court court-1 idx-${idx}"><div class="court-title">${title}</div><div class="court-content">${content}</div><div class="court-defendant" style="display:none;">${defendant}</div><div class="court-delator" style="display:none;">${delator} </div><div class="court-deadline" style="display:none;">${deadline}</div><div class="court-defendant-point" style="display:none;">${defendant_point} </div><div class="court-delator-point" style="display:none;">${delator_point} </div></div>`)
    }else{
        $('.court-main').prepend(`<div onClick="toDetail(${idx}, 0)" class="court court-1 idx-${idx}"><div class="court-title court-end">${title}</div><div class="court-content"> ${content}</div><div class="court-content-text" style="display:none;">${content}</div><div class="court-defendant" style="display:none;">${defendant}</div><div class="court-delator" style="display:none;">${delator} </div><div class="court-deadline" style="display:none;">${deadline}</div><div class="court-defendant-point" style="display:none;">${defendant_point} </div><div class="court-delator-point" style="display:none;">${delator_point} </div></div></div>`)
    }
})

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
