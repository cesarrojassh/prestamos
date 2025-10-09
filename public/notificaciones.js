function toast_info(msg, type, icon) {
	Lobibox.notify(type, {
		pauseDelayOnHover: true,
		icon: icon,
		continueDelayOnInactiveTab: false,
		position: 'top center',
		size: 'mini',
		msg: msg
	});
}

function toast_right(msg, type, icon) {
	Lobibox.notify(type, {
		pauseDelayOnHover: true,
		icon: icon,
		continueDelayOnInactiveTab: false,
		position: 'top center',
		size: 'mini',
		msg: msg
	});
}




