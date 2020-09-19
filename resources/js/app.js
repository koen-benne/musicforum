document.addEventListener("DOMContentLoaded", function(event) {

    let audioPlayers = document.getElementsByTagName('audioplayer');

    for (let i = 0; i < audioPlayers.length; i++) {

        let music = audioPlayers[i].getElementsByClassName('music')[0]; // id for audio element
        let playButton = audioPlayers[i].getElementsByClassName('play-button')[0]; // play button
        let playhead = audioPlayers[i].getElementsByClassName('playhead')[0]; // playhead
        let timeline = audioPlayers[i].getElementsByClassName('timeline')[0]; // timeline

        // timeline width adjusted for playhead
        let timelineWidth = timeline.offsetWidth - playhead.offsetWidth;
        let duration;


        // play button event listenter
        playButton.addEventListener("click", play);

        // timeupdate event listener
        music.addEventListener("timeupdate", timeUpdate, false);

        // makes timeline clickable
        timeline.addEventListener("click", function(event) {
            moveplayhead(event);
            music.currentTime = duration * clickPercent(event);
        }, false);

        function clickPercent(event) {
            return (event.clientX - getPosition(timeline)) / timelineWidth
        }

        // makes playhead draggable
        playhead.addEventListener('mousedown', mouseDown, false);
        window.addEventListener('mouseup', mouseUp, false);

        // Boolean value so that audio position is updated only when the playhead is released
        let onplayhead = false;

        // mouseDown EventListener
        function mouseDown() {
            onplayhead = true;
            window.addEventListener('mousemove', moveplayhead, true);
            music.removeEventListener('timeupdate', timeUpdate, false);
        }

        // mouseUp EventListener
        // getting input from all mouse clicks
        function mouseUp(event) {
            if (onplayhead === true) {
                moveplayhead(event);
                window.removeEventListener('mousemove', moveplayhead, true);
                // change current time
                music.currentTime = duration * clickPercent(event);
                music.addEventListener('timeupdate', timeUpdate, false);
            }
            onplayhead = false;
        }
        // mousemove EventListener
        // Moves playhead as user drags
        function moveplayhead(event) {
            let newMargLeft = event.clientX - getPosition(timeline);

            if (newMargLeft >= 0 && newMargLeft <= timelineWidth) {
                playhead.style.marginLeft = newMargLeft + "px";
            }
            if (newMargLeft < 0) {
                playhead.style.marginLeft = "0px";
            }
            if (newMargLeft > timelineWidth) {
                playhead.style.marginLeft = timelineWidth + "px";
            }
        }

        // timeUpdate
        // Synchronizes playhead position with current point in audio
        function timeUpdate() {
            let playPercent = timelineWidth * (music.currentTime / duration);
            playhead.style.marginLeft = playPercent + "px";
            if (music.currentTime === duration) {
                playButton.className = "";
                playButton.className = "play-button play";
            }
        }

        //Play and Pause
        function play() {
            // start music
            if (music.paused) {
                music.play();

                let buttonsToPause = document.getElementsByClassName('pause');
                for (i = 0; i < buttonsToPause.length; i++) {
                    let button = buttonsToPause[i];
                    let audioToPause = button.parentElement.parentElement.getElementsByClassName('music')[0]
                    audioToPause.pause();

                    button.classList.remove('pause')
                    button.classList.add('play')
                }

                // remove play, add pause
                playButton.classList.remove('play')
                playButton.classList.add('pause')
            } else { // pause music
                music.pause();
                // remove pause, add play
                playButton.classList.remove('pause')
                playButton.classList.add('play')
            }
        }

        // Gets audio file duration
        music.addEventListener("canplaythrough", function() {
            duration = music.duration;
        }, false);

        // getPosition
        // Returns elements left position relative to top-left of viewport
        function getPosition(el) {
            return el.getBoundingClientRect().left;
        }
    }
});
