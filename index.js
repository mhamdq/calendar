(function(){
    const evtBox = document.querySelector('.containers');
    const calendarEvt = document.querySelectorAll('.calendar-events')

    evtBox.classList.add('notVisible')
    console.log(evtBox)
    calendarEvt.forEach(element => {
        element.addEventListener('click',(event) =>{
            event.preventDefault()
            evtBox.classList.remove('notVisible')
        })
    });
}());