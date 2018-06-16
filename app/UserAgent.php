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

        if ($this->browser_name) {
            return $this;
        }

        $dd = new DeviceDetector( $this->name );
        $dd->parse();

        $client = $dd->getClient();
        $this->is_bot = $dd->isBot();
        if ($dd->isBot()) {
            $bot = $dd->getBot();
            $this->browser_type = isset($bot['category']) ? $bot['category'] : null;
            $this->browser_name = $bot['name'];
        }
        if ($client) {
            $this->browser_type = isset($client['type']) ? $client['type'] : null;
            $this->browser_name = $client['name'];
            $this->browser_version = isset($client['version']) ? $client['version'] : null;
        }
        $os = $dd->getOs();
        if ($os) {
            $this->os_name = isset($os['name']) ? $os['name'] : null;
            $this->os_version = isset($os['version']) ? $os['version'] : null;
            $this->os_platform = isset($os['platform']) ? $os['platform'] : null;
        }

        $this->save();

        return $this;
    }
}
