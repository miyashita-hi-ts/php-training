var toggle_color = ''
var os_color = ''
const saved_value = Cookies.get('color_theme_value');

//
if (!saved_value) {
    // Cookieが存在しなければOSのダークモード判定
    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.documentElement.setAttribute('data-mode', 'dark')
        var os_color = 'dark'
        // Cookieが存在しなければトグル用のチェックボックスをcheckedにする
        jQuery('#color-mode').prop('checked', true);
    } else {
        document.documentElement.setAttribute('data-mode', 'light')
        var os_color = 'light'
    }
} else {
    if (saved_value=='dark') {
        document.documentElement.setAttribute('data-mode', 'dark')
        //var os_color = 'dark'
    } else {
        document.documentElement.setAttribute('data-mode', 'light')
        //var os_color = 'light'
    }
}

window.matchMedia('(prefers-color-scheme: dark)').addListener(e => {
  if (e.matches) {
    document.documentElement.setAttribute('data-mode', 'dark')
  } else {
    document.documentElement.setAttribute('data-mode', 'light')
    var color = 'light'
  }
});

// トグルボタンでダークモード切り替え
const btn = document.querySelector("#color-mode");

btn.addEventListener("change", () => {
  if (btn.checked == true) {
    document.documentElement.setAttribute('data-mode', 'dark')
    toggle_color = 'dark'
  } else {
    document.documentElement.setAttribute('data-mode', 'light')
    toggle_color = 'light'
  }
});

// Cookie保存
jQuery("#color-mode").change(function(e){
    if (!toggle_color) {
        save_value = os_color
    } else {
        save_value = toggle_color
    }
    Cookies.set('color_theme_value', save_value , { expires: 7 });
});
