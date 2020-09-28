document.addEventListener("DOMContentLoaded", function(event) {

    let /**HTMLElement*/draggingPlayhead = null;

    document.addEventListener('click', function(e) {
        const target = e.target;
        const classList = target.classList;

        if (classList.contains('play-button')) {
            if (onAudioReady(target)) {
                target.blur();
                playButtonPressed(target);
            }
        }
        else if (classList.contains('timeline')) {
            if (onAudioReady(target)) {
                movePlayhead(e, true);
            }
        }

    });

    document.addEventListener('mousedown', function (e) {
        const target = e.target;
        const classList = target.classList;

        if (classList.contains('playhead') || draggingPlayhead !== null) {
            dragPlayhead(e);
        }
    });

    document.addEventListener('mouseup', function (e) {
        if (draggingPlayhead !== null) {
            releasePlayhead(e);
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === ' ') {
            const audioPlayer = getPlayingAudio();
            if (audioPlayer) {
                const playButton = audioPlayer.getElementsByClassName('play-button')[0];
                playButtonPressed(playButton);
            }
        }
    });

    function onAudioReady(target) {
        const audioPlayer = target.parentElement.parentElement;
        const /**HTMLAudioElement*/music = audioPlayer.getElementsByTagName('audio')[0];
        if (music.readyState === 4) {
            return true;
        } else {
            music.addEventListener('canplaythrough', function () {
                playButtonPressed(target);
            });
        }
    }


    function playButtonPressed(button) {
        const audioPlayer = button.parentElement.parentElement;
        const audio = audioPlayer.getElementsByTagName('audio')[0];

        if (button.classList.contains('play')) {
            play(audio, button);
        } else {
            pause(audio, button);
        }
    }

    function play(audio, button) {
        const audioPlayer = button.parentElement.parentElement;

        // Pause other track if necessary and remove now-playing id
        if (audioPlayer.id !== 'now-playing') {
            const nowPlaying = document.getElementById('now-playing');
            if (nowPlaying) {
                const audioToPause = nowPlaying.getElementsByTagName('audio')[0];
                const buttonToPause = nowPlaying.getElementsByClassName('play-button')[0];

                audioToPause.pause();
                buttonToPause.classList.replace('pause', 'play');

                nowPlaying.id = '';

                audio.removeEventListener('timeupdate', syncPlayheadToAudio);
            }

            audioPlayer.id = 'now-playing';
            audio.addEventListener('timeupdate', syncPlayheadToAudio);
        }
        // Play song
        audio.play();
        button.classList.replace('play', 'pause');

    }

    function pause(music, button) {

        music.pause();
        button.classList.replace('pause', 'play');

    }


    function movePlayhead(event, updateAudio = false) {
        const target = event.target;
        let audioPlayer;
        let playhead;
        let timeline;
        if (draggingPlayhead) {
            audioPlayer = draggingPlayhead.parentElement.parentElement.parentElement;
            playhead = draggingPlayhead;
            timeline = draggingPlayhead.parentElement;
        } else {
            timeline = target;
            audioPlayer = target.parentElement.parentElement;
            playhead = target.getElementsByClassName('playhead')[0];
        }

        const music = audioPlayer.getElementsByTagName('audio')[0];


        const newMarginLeft = event.clientX - getPosition(timeline);

        const timelineWidth = timeline.offsetWidth - playhead.offsetWidth;

        if (newMarginLeft >= 0 && newMarginLeft <= timelineWidth) {
            playhead.style.marginLeft = newMarginLeft + "px";
        }
        if (newMarginLeft < 0) {
            playhead.style.marginLeft = "0px";
        }
        if (newMarginLeft > timelineWidth) {
            playhead.style.marginLeft = timelineWidth + "px";
        }

        music.currentTime = music.duration * clickPercent(event, timeline, timelineWidth);
    }


    function changeTime(music, sec) {
        music.currentTime += sec;
        syncPlayheadToAudio();
    }


    function dragPlayhead(event) {
        document.body.classList.add('no-select');

        draggingPlayhead = event.target;
        const audioPlayer = draggingPlayhead.parentElement.parentElement.parentElement;
        const audio = audioPlayer.getElementsByTagName('audio')[0];
        window.addEventListener('mousemove', movePlayhead, true);
        if (audioPlayer.id === 'now-playing') {
            audio.removeEventListener('timeupdate', syncPlayheadToAudio, false);
        }
    }

    function releasePlayhead(event) {
        window.removeEventListener('mousemove', movePlayhead, true);
        const audioPlayer = draggingPlayhead.parentElement.parentElement.parentElement;
        const audio = audioPlayer.getElementsByTagName('audio')[0];
        const timeline = draggingPlayhead.parentElement
        const timelineWidth = timeline.offsetWidth - draggingPlayhead.offsetWidth;
        // change current time
        audio.currentTime = audio.duration * clickPercent(event, timeline, timelineWidth);
        if (audioPlayer.id === 'now-playing') {
            audio.addEventListener('timeupdate', syncPlayheadToAudio, false);
        }
        document.body.classList.remove('no-select');
        draggingPlayhead = null;
    }


    // Synchronizes playhead position with current point in audio
    function syncPlayheadToAudio() {
        const audioPlayer = getPlayingAudio();
        const timeline = audioPlayer.getElementsByClassName('timeline')[0];
        const playhead = timeline.getElementsByClassName('playhead')[0];
        const playButton = audioPlayer.getElementsByClassName('play-button')[0];
        const audio = audioPlayer.getElementsByTagName('audio')[0];

        const timelineWidth = timeline.offsetWidth - playhead.offsetWidth;
        const duration = audio.duration;

        let playPercent = timelineWidth * (audio.currentTime / duration);
        playhead.style.marginLeft = playPercent + "px";
        if (audio.currentTime === duration) {
            playButton.classList.replace('pause', 'play')
        }
    }

    function getPosition(el) {
        return el.getBoundingClientRect().left;
    }

    function clickPercent(event, timeline, timelineWidth) {
        return (event.clientX - getPosition(timeline)) / timelineWidth
    }

    function getPlayingAudio() {
        return document.getElementById('now-playing');
    }

});
