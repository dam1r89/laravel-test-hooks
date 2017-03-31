<?php
namespace dam1r89\TestHooks\Http\Controller;

use dam1r89\TestHooks\Database\Database;
use dam1r89\TestHooks\Date\Date;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TestingController extends Controller
{
    public function index(Database $db, Date $date)
    {
        return [
            'states' => $db->getStates(),
            'date' => $date->get()
        ];
    }

    public function save(Request $request, Database $db)
    {
        try {
            $db->saveState($request->get('state'), $request->has('force'));
        } catch (\Exception $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }

        return [
            'success' => true,
        ];
    }

    public function reset(Request $request, Database $db)
    {
        try {
            $db->resetState($request->get('state'));
            \Artisan::call('migrate');
        } catch (\Exception $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
        return [
            'success' => true,
        ];
    }

    public function date()
    {
        return Carbon::now();
    }

    public function setDate(Date $date, Request $request)
    {
        return ['testDate' => $date->setDate($request->get('date'))];
    }

    public function clearDate(Date $date)
    {

        $date->clear();
        return ['success' => true];
    }

}
