<audioplayer>

    <audio class="music" preload="true">
        <source src="audio/{{ $songTitle }}.wav">
    </audio>

    <div class="song-container">
        <h2>{{ $songTitle }}</h2>
        <audiocontrolls>
            <button class="play-button play"></button>
            <div class="timeline">
                <div class="playhead"></div>
            </div>
        </audiocontrolls>
    </div>

</audioplayer>
