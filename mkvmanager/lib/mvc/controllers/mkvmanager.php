<?php
class mmMkvManagerController extends ezcMvcController
{
    public function doDefault()
    {
        return new ezcMvcResult;
    }

    public function doFatal()
    {
        $result = new ezcMvcResult;
        $result->variables['exception'] = isset( $this->request->variables['exception'] );
        $result->variables['page_title'] = "An error has occured";
        return $result;
    }

    public function doTest()
    {
        echo "HEY";
        return new ezcMvcResult();
    }

    public function doMkvMerge()
    {
        $result = new ezcMvcResult;
        $result->variables['page_title'] = "MKV Merge command manager :: MKV Manager";
        $result->variables['targetDisks'] = mmMkvManagerDiskHelper::diskList();
        if ( isset( $_POST['WinCmd'] ) )
            $result->variables += mmApp::doConvertWinCMD( $_POST['WinCmd'], $_POST['Target'] );
        return $result;
    }

    /**
    * Controller method for the subtitles route
    * @return ezcMvcResult
    */
    public static function doSubtitles()
    {
        $result = new ezcMvcResult;
        $result->variables['page_title'] = "Subtitles manager :: MKV Manager";
        $result->variables += mmApp::doSubtitles();
        return $result;
    }

    /**
     * tvshow/image callback. Displays one of the show's image files, as found in
     * the Sorted folder
     *
     * @param string $image Image filename (fanart.jpg, folder.jpg...)
     *
     * @todo Catch the result by a) logging b) throwing a 404
     * @return ezcMvcResult
     */
    public function doTVShowImage()
    {
        $result = new ezcMvcResult;

        if ( $this->image == '' )
            throw new ezcBaseValueException( 'image', $this->image );

        $file = "/home/download/downloads/complete/TV/Sorted/" . str_replace( ':', '/', $this->image );
        // @todo Throw a dedicated extension
        if ( !file_exists( $file ) )
            throw new ezcBaseValueException( 'image', $file );

        $finfo = new finfo( FILEINFO_MIME );
        header( "Content-Type: " . $finfo->file( $file ) );
        readfile( $file );
        exit;

        return $result;
    }

    /**
     * Lists movies with no NFO files
     */
    public function doMoviesWithoutNFO()
    {
        $result = new ezcMvcResult();
        $result->variables['page_title'] = "Missing NFOs tracker :: MKV Manager";
        $result->variables += mmApp::doMoviesWithoutNFO();
        return $result;
    }

    /**
     * Shows the merge queue items
     */
    public function doMergeQueue()
    {
        $result = new ezcMvcResult();
        $result->variables['page_title'] = 'Merge queue status :: MKV Manager';
        return $result;
    }
}
?>
