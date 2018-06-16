<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DeviceDetector\DeviceDetector;

class UserAgent extends Model
{
    protected $fillable = [ 'name' ];

    function views() {
        return $this->hasMany( View::class );
    }

    function addDetails() {
        $dd = new DeviceDetector( $this->name );
        $dd->parse();
        $client = $dd->getClient();
        $this->is_bot = $dd->isBot();
        if ($dd->isBot()) {
            $bot = $dd->getBot();
            $this->browser_type = $bot['category'];
            $this->browser_name = $bot['name'];
        }
        if ($client) {
            $this->browser_type = $client['type'];
            $this->browser_name = $client['name'];
            $this->browser_version = $client['version'];
        }
        $os = $dd->getOs();
        if ($os) {
            $this->os_name = $os['name'];
            $this->os_version = $os['version'];
            $this->os_platform = $os['platform'];
        }
        $this->save();
        return $this;
    }
}
