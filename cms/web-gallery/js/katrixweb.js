function kekoprofilecheck() {
    if (mirocheckprofitimeou != null) {
        clearTimeout(mirocheckprofitimeou)
    }
    mirocheckprofitimeou = setTimeout("miroyapprofnw()", 1e3)
}
function enviyawowperf() {
    var e = document.getElementById("compartirprof").value;
    if (e != "") {
        var t = "";
        for (var n in uspaprofcomurl) {
            if (uspaprofcomurl[n] != null) {
                if (uspaprofcomurl[n] == "tt") {
                    var r = document.getElementById(n + "aa").innerHTML;
                    uspaprofcomurl[n] = uspaprofcomurl[n] + document.getElementById(n + "mm" + r).innerHTML + "::AAAAAAPAA::" + document.getElementById(n + "ttttt").innerHTML + "::AAAAAAPAA::" + document.getElementById(n + "ddddd").innerHTML
                }
                t += "" + uspaprofcomurl[n] + "::--::--xxxx::" + n + ">>->->-<--<--<<<";
                uspaprofcomurl[n] = undefined;
                var i = document.getElementById("dur" + n);
                if (i.parentNode) {
                    i.parentNode.removeChild(i)
                }
            }
        }
        document.getElementById("compartirprof").value = "";
        uspaprofcomurl = [];
        var s = "2";
        $.ajax({type: "POST", url: "todoincs/funcop.php", data: {op: "publicar", perfil: pakie, canal: s, annahtmmsh: t, annahtm: e}})
    }
}
function replaceAlltodo(e, t, n) {
    while (e.toString().indexOf(t) != - 1)
        e = e.toString().replace(t, n);
    return e
}
function miroyapprofnw() {
    var e = document.getElementById("compartirprof").value;
    e = replaceAlltodo(e, "https://", "http://");
    e = replaceAlltodo(e, "www.", "http://");
    e = replaceAlltodo(e, "http://http://", "http://");
    e = replaceAlltodo(e, "\n", " ");
    var t = e.split("http://");
    var n = "";
    var r = "";
    var i = "";
    var s = new Array;
    if (t[1] != undefined) {
        for (var o in t) {
            if (o > 0) {
                n = t[o];
                r = n.split(" ");
                i = r[0];
                if (i != "") {
                    s[i] = "si";
                    if (uspaprofcomurl[i] == undefined) {
                        uspaprofcomurl[i] = "si";
                        proccurccporfile(i)
                    }
                }
            }
        }
    }
    for (var o in uspaprofcomurl) {
        if (s[o] == undefined && uspaprofcomurl[o] != undefined) {
            uspaprofcomurl[o] = undefined;
            var u = document.getElementById("dur" + o);
            if (u.parentNode) {
                u.parentNode.removeChild(u)
            }
        }
    }
}
function miniimag(e, t) {
    var n = parseFloat(document.getElementById(e + "aa").innerHTML);
    var r = parseFloat(document.getElementById(e + "tt").innerHTML);
    if (t == "a" && n > 1) {
        document.getElementById(e + "mm" + n).style.display = "none";
        n--;
        document.getElementById(e + "mm" + n).style.display = "";
        document.getElementById(e + "aa").innerHTML = n
    } else if (t == "d" && r > n) {
        document.getElementById(e + "mm" + n).style.display = "none";
        n++;
        document.getElementById(e + "mm" + n).style.display = "";
        document.getElementById(e + "aa").innerHTML = n
    }
}
function proccurccporfile(e) {
    var t = document.getElementById("masconapub");
    var n = document.createElement("div");
    n.id = "dur" + e;
    if (e.toString().indexOf("youtu") == 0) {
        var r = e.split("v=");
        var i = r[1];
        if (i == null)
            i = "no";
        var s = i.split("&");
        var o = s[0];
        uspaprofcomurl[e] = "tt";
        var u = http_reqstodo("./fly/tvweb/index.php", "queryType=addtocom&videoId=" + o + "&staopsqqwuadasd=" + e)
    } else {
        uspaprofcomurl[e] = "ll";
        var u = http_reqstodo("./fly/print/index.php", "d=" + e + "&pr=1")
    }
    n.innerHTML = u;
    t.appendChild(n)
}
function http_reqstodo(e, t) {
    if (window.XMLHttpRequest) {
        var n = new XMLHttpRequest
    } else if (window.ActiveXObject) {
        try {
            var n = new ActiveXObject("Msxml2.XMLHTTP")
        } catch (r) {
            try {
                var n = new ActiveXObject("Microsoft.XMLHTTP")
            } catch (r) {
                return false
            }
        }
    }
    if (!n) {
        return false
    }
    if (t) {
        n.open("POST", e, false);
        n.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        n.send(t)
    } else {
        n.open("GET", e, false);
        n.send(null)
    }
    if (n.status == 200) {
        return n.responseText
    } else {
        return false
    }
}
function enviaridea() {
    $.ajax({type: "POST", url: "todoincs/funcop.php", data: {op: "idea", idc: $("#idea").val()}}).done(function(e) {
        kmensaj("noti", "KekoCity", "1", "default", e)
    })
}
function kmensaj(e, t, n, r, i) {
    var s = "n" + $(".contenidoal").length + "m";
    var o = '<img src="http://kekocity.es/imgprofile/' + r + '.png" style="border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;float:left;width:50px;height:50px;">' + t;
    o += "<br/>" + i;
    var u = 80;
    if ($(".contenidoal").length > 0) {
        u += $(".contenidoal").length * 62
    }
    var a = document.createElement("div");
    a.id = s;
    a.style.color = "#fff";
    a.style.position = "absolute";
    a.className = "contenidoal";
    a.style.minHeight = "80px";
    a.style.maxHeight = "80px";
    a.style.top = u + "px";
    a.style.width = "200px";
    a.style.right = "-230px";
    a.style.zIndex = 1001;
    if (e == "online") {
        a.style.cursor = "pointer"
    } else {
        a.style.cursor = "default"
    }
    a.innerHTML = o;
    document.body.appendChild(a);
    var f = 9500;
    if (e == "carregando") {
        f = 1500
    } else if (e == "cargandod") {
        f = 4500
    }
    soni("http://kekocity.es/images/" + e + ".mp3");
    $("#" + s).animate({right: "+=250"}, "fast", function() {
        var e = $(this).attr("id");
        setTimeout(function() {
            $("#" + e).animate({right: "-=250"}, "fast", function() {
                $(this).remove()
            })
        }, f)
    })
}
function vercomentsde(e) {
    if (document.getElementById("allconets" + e).style.display == "none" || document.getElementById("allconets" + e).style.display == "block") {
        $.ajax({type: "POST", url: "http://kekocity.es/todoincs/funcop.php", data: {op: "vercomentariosde", idc: e}}).done(function(t) {
            document.getElementById("allconets" + e).style.display = "";
            $("#allconets" + e + " > div:first").html(t);
            $("#allconets" + e).slimScroll({height: "100%"})
        })
    } else {
        document.getElementById("allconets" + e).style.display = "none"
    }
}
function borrcoma(e, t) {
    $.ajax({type: "POST", url: "http://kekocity.es/todoincs/funcop.php", data: {op: "borrarcomentario", idco: t, idc: e}}).done(function(n) {
        var r = parseInt($("#cuantoscom" + e).html());
        if (r > 0) {
            r--
        }
        $("#cuantoscom" + e).html(r);
        $("#comm" + t).remove()
    })
}
function comm(e) {
    var t = document.getElementById("qcomen" + e).value;
    $.ajax({type: "POST", url: "http://kekocity.es/todoincs/funcop.php", data: {op: "comentar", idc: e, comentario: t}}).done(function(t) {
        if (t == "OK") {
            document.getElementById("qcomen" + e).value = "";
            document.getElementById("allconets" + e).style.display = "block";
            vercomentsde(e)
        }
    })
}
function cargandowowyaj(e, t, n, r) {
    $("#cargandowowya").css("display", "none");
    $("#cargandowow").css("display", "");
    pag++;
    $.ajax({type: "POST", url: "http://kekocity.es/todoincs/funcop.php", data: {op: "cargasocial", perfil: e, pag: pag, id: t, totpag: n}}).done(function(e) {
        if (r != "arri")
            $(e).appendTo("#akisoci");
        else
            $(e).insertAfter("#akisociant");
        yaconectsjs();
        $("#cargandowowya").css("display", "");
        $("#cargandowow").css("display", "none")
    })
}
var idiweb = ["faz", "segundos", "minutos", "minuto", "agora mesmo"];
var yahola = false;
var hola = function() {
    yahola = true;
    var e = "share";
    var t = window.open(e, "Factory", "location=no,directories=no,status=no,toolbar=no,menubar=no,width=1200,resizable=yes,height=600")
};
var hola2 = function() {
    yahola = true;
    var e = "loading";
    var t = window.open(e, "Factory", "location=no,directories=no,status=no,toolbar=no,menubar=no,width=1200,resizable=yes,height=600")
};
var socket = null;
var pag = 1;
var yaconect = new Array;
var yaconectime = new Array;
var yaconectsjs = function() {
    var e = $(".boxkatrix").toArray();
    var t = 0;
    for (var n in e) {
        t = e[n].getAttribute("data-idc");
        if (yaconect[t] == null) {
            yaconect[t] = true;
            socket.emit("conectidc", t)
        }
        if (yaconectime[t] == null) {
            yaconectime[t] = true;
            cuandtime(t, e[n].getAttribute("data-cuand"))
        }
        t = e[n].getAttribute("data-idcan");
        if (yaconect[t] == null) {
            yaconect[t] = true;
            socket.emit("conectidc", t)
        }
    }
};