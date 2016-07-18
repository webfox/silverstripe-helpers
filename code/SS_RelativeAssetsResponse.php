<?php

/**
 * Class SS_RelativeAssetsResponseExtension
 *
 * @property Controller $owner
 */
class SS_RelativeAssetsResponseExtension extends Extension
{

    function onBeforeInit()
    {
        if (is_a($this->owner, 'Controller')) {
            $this->owner->response = new SS_RelativeAssetsResponse();
        }
    }

}

class SS_RelativeAssetsResponse extends SS_HTTPResponse
{
    public function setBody($body)
    {
        $this->body = $body ? (string)$body : $body;

        //
        $this->body = str_replace('"/assets/', '"assets/', $this->body);
        $this->body = str_replace('"assets/', '"/assets/', $this->body);
    }


}
