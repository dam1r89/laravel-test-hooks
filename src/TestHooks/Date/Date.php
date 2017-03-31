<?php
namespace dam1r89\TestHooks\Date;
use Carbon\Carbon;
use Illuminate\Session\Store;


/**
 * Created by PhpStorm.
 * User: dam1r89
 * Date: 3/31/17
 * Time: 11:57 AM
 */
class Date
{

    private $store;

    /**
     * Date constructor.
     * @param $store
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
        session();
    }

    public function get()
    {
        return $this->store->get('test-date');
    }

    public function setDate($date)
    {
        if (empty($date)) {
            $this->clear();
            return null;
        }
        $date = $date instanceof \DateTime ? $date : Carbon::parse($date);
        $this->store->set('test-date', $date);
        return $date;
    }

    public function clear()
    {
        return $this->store->forget('test-date');
    }
}
