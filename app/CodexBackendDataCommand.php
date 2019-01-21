<?php

namespace App;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CodexBackendDataCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'codex:backend';


    public function handle()
    {

//        $this->line( SchemaPrinter::doPrint(
//            graphql()->prepSchema()
//        ));
        $r = graphql()->executeQuery(<<<'EOT'
query Test {
    codex {   
        display_name
        description
        cache {
            enabled
            minutes
        }
        http @assoc
        default_project      
        layout @assoc
        urls {
            api
            documentation
            root
        }
        projects {
            key
            display_name
            description
            default_revision
            revisions {
                key
                default_document
            }
        }
    }
    config {
        locale
        fallback_locale
        timezone
        name
        url
    }
}
EOT
            , null, []);
        if (count($r->errors) > 0) {
            $this->line($r->errors[ 0 ]->getTraceAsString());
            $this->line($r->errors[ 0 ]->getMessage());
            $this->line(count($r->errors) . ' errors in total');
        }

        $this->line(json_encode($r->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

}
