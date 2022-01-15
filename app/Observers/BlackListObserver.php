<?php

namespace App\Observers;

use App\Models\BlackList;

class BlackListObserver
{
    public function saved(BlackList $blackList)
    {
        $type = (int)$blackList->type === BlackList::TYPE_IP ? 'ip' : 'phone';
        BlackList::setConfig($type);
    }

    public function deleted(BlackList $blackList)
    {
        $type = (int)$blackList->type === BlackList::TYPE_IP ? 'ip' : 'phone';
        BlackList::setConfig($type);
    }
}
