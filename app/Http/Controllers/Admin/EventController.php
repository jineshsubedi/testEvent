<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventRequest;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EventController extends Controller
{
    protected $disk = 'public';
    protected $path = 'events';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Event::query();
        $query->with(['user:id,name']);
        $filter = $this->filterQuery($query);
        $events = $filter->orderBy('start_date')->paginate(10);
        return Inertia::render('Admin/Event/Index', [
            'events' => $events,
            'filters' => $request->only(['type'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Event/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        Event::create($request->validated() + [
            'user_id' => auth()->id(),
            'image' => $request->hasFile('banner') ? $request->file('banner')->store($this->path, $this->disk) : null
        ]);
        return redirect()->route('admin.events.index')->with('success', 'Event Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $event->load(['user:id,name']);
        return Inertia::render('Admin/Event/Show',[
            'event' => $event
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return Inertia::render('Admin/Event/Edit',[
            'event' => $event
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, Event $event)
    {
        $image_path = $event->image;
        if($request->hasFile('banner'))
        {   
            if($event->image != null)
                $this->deleteFile($image_path);
            $image_path = $request->file('banner')->store($this->path, $this->disk);
        }
        $event->update($request->validated() + [
            'image' => $image_path
        ]);
        return redirect()->route('admin.events.index')->with('success', 'Event Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        if($event->image != null)
            $this->deleteFile($event->image);
        $event->delete();
        return back()->with('success', 'Event Deleted Successfully!');
    }

    private function filterQuery($query)
    {
        if(request()->filled('type'))
        {
            if(request()->type == 'upcomming')
            {
                $query->upcomming();
            }
            if(request()->type == 'running')
            {
                $query->running();
            }
            if(request()->type == 'finished')
            {
                $query->finished();
            }
            if(request()->type == 'latest_upcomming')
            {
                $query->latestUpcomming();
            }
            if(request()->type == 'earliest_finish')
            {
                $query->earliestFinish();
            }
        }
        return $query;
    }
    public function deleteFile($image)
    {
        if(Storage::exists($image))
        {
            Storage::delete($image);
        }
    }
}
