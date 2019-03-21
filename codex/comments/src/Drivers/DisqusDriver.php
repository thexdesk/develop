<?php

namespace Codex\Comments\Drivers;

class DisqusDriver extends CommentDriver
{
    /** @var array */
    protected $config;

    /** @var string */
    protected $shortCode;

    public function __construct(array $config)
    {
        $this->config    = $config;
        $this->shortCode = $config[ 'shortcode' ];
    }

    public function render(array $options = [])
    {
        $request = request();
        $url     = $options[ 'url' ] ?? $request->getUri();
        $id      = $options[ 'id' ];
        $html    = <<<EOT
<div class="c-comments">        
    <div id="disqus_thread"></div>
</div>
EOT;
        $script  = <<<EOT
(function() { 
    var id = setInterval(function(){
    
        if(!window.document.getElementById('disqus_thread')){
            return;
        }
        
        clearInterval(id);
    
        var disqus_config = function () {
            this.page.url = '{$url}';  
            this.page.identifier = '{$id}'; 
        };
        
        var s = window.document.createElement('script');
        s.src = 'https://{$this->shortCode}.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (window.document.head || window.document.body).appendChild(s);
    }, 100);
})();
EOT;
        $style   = <<<EOT

EOT;

        return compact('html', 'script', 'style');
    }

}
