<!DOCTYPE html>
    <html>
    <title>VLC Mozilla plugin test page</title>
    <body>
    <embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org"
       width="320"
       height="240"
       target="rtsp://admin:Hik12345@ferreboom.com:554/Streaming/Channels/201"
       id="vlc" />
       <iframe src="rtsp://admin:Hik12345@ferreboom.com:554/Streaming/Channels/201" width="800px" height="600px"/>
    <script type="text/javascript">
    <!--
    var vlc = document.getElementById("vlc");
vlc.audio.toggleMute();
//-->
</script>
</body>
</html>