<?php namespace FrenchFrogs\Core;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail;
use FrenchFrogs;
use Response, Request, Route, Input, Blade, Auth;

class FrenchFrogsServiceProvider  extends ServiceProvider
{

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        foreach(config('frenchfrogs') as $namespace => $config) {
            configurator($namespace)->merge($config);
        }
    }

    /**
     * Datatable render
     * @param string $route
     */
    public function bootDatatable($route = '/datatable')
    {
        Route::get($route, function() {

            $request = request();

            $table = FrenchFrogs\Table\Table\Table::load($request->get('token'));

            $table->setItemsPerPage(Input::get('length'));
            $table->setPageFromItemsOffset(Input::get('start'));
            $table->setRenderer(new FrenchFrogs\Table\Renderer\Remote());

            foreach(request()->get('columns') as $c) {
                if ($c['searchable'] == "true" && $c['search']['value'] != '') {
                    $table->getColumn($c['name'])->getStrainer()->call($table, $c['search']['value']);
                }
            }

            $search = $request->get('search');
            if (!empty($search['value']) ) {
                $table->search($search['value']);
            }

            $order = $request->get('order');
            if (!empty($order)) {
                foreach($order as $o) {
                    extract($o);
                    $table->getColumnByIndex($column)->order($dir);
                }
            }

            $data = [];
            foreach($table->render() as $row){
                $data[] = array_values($row);
            }

            return response()->json(['data' => $data, 'draw' => Input::get('draw'), 'recordsFiltered' => $table->getItemsTotal(), 'recordsTotal' => $table->getItemsTotal()]);

        })->name('datatable');
    }

    /**
     * Modal Manager
     */
    public function bootModal()
    {
        Response::macro('modal', function($title, $body = '', $actions  = [])
        {
            if ($title instanceof FrenchFrogs\Modal\Modal\Modal) {
                $modal = $title->enableRemote();
            } elseif($title instanceof FrenchFrogs\Form\Form\Form) {
                $renderer = configurator()->get('form.renderer.modal.class');
                $modal = $title->setRenderer(new $renderer());
            } else {
                $modal = modal($title, $body, $actions)->enableRemote();
            }

            $modal .= '<script>jQuery(function() {'.js('onload').'});</script>';

            return $modal;
        });
    }

    public function bootMail()
    {
        /**
         * Mail manager
         *
         * @param string $view
         * @param array $data
         * @param array $from
         * @param array $to
         * @param string $subject
         * @param array $attach
         */
        Response::macro('mail', function($view, $data = [], $from = [], $to = [], $subject = '', $attach = []) {

            if ($from instanceof Mail\Message) {
                \Mail::send($view, $data, function (Mail\Message $message) use ($from, $attach) {

                    // Getting the generated message
                    $swift = $from->getSwiftMessage();

                    // Setting the mandatory arguments
                    $message->subject($swift->getSubject());
                    $message->from($swift->getFrom());
                    $message->to($swift->getTo());

                    // Getting the optional arguments
                    if (!empty($swift->getSender()))    { $message->sender($swift->getSender()); }
                    if (!empty($swift->getCc()))        { $message->cc($swift->getCc()); }
                    if (!empty($swift->getBcc()))       { $message->bcc($swift->getBcc()); }
                    if (!empty($swift->getReplyTo()))   { $message->replyTo($swift->getReplyTo()); }
                    if (!empty($swift->getPriority()))  { $message->priority($swift->getPriority()); }

                    // Managing multiple attachment
                    foreach ($attach as $file)          { $message->attach($file); }
                });

            } else {
                \Mail::send($view, $data, function (Mail\Message $message) use ($from, $to, $subject, $attach) {
                    // Setting the mandatory arguments
                    $message->from(...$from)->subject($subject);

                    // Managing multiple to
                    foreach ($to as $mail)      { $message->to(...$mail); }
                    // Managing multiple attachment
                    foreach ($attach as $file)  { $message->attach($file); }
                });
            }
        });
    }

    /**
     * Publish asset frenchfrogs
     */
    public function publish(){
        // Asset management
        $this->publishes([
            __DIR__.'/../../assets' => base_path('resources/assets'),
        ], 'frenchfrogs');
    }


    public function boot()
    {
        $this->bootDatatable();
        $this->bootModal();
        $this->bootMail();
        $this->publish();
    }
}