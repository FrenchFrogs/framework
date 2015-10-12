<?php namespace FrenchFrogs\Core;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail;
use FrenchFrogs;
use Response, Request, Route, Input, Blade;

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



    public function boot()
    {
        /**
         * Datatable render
         *
         */
        Route::get('/datatable', function() {
            $table = \FrenchFrogs\Polliwog\Table\Table\Table::load(request()->get('token'));

            $table->setItemsPerPage(Input::get('length'));
            $table->setPageFromItemsOffset(Input::get('start'));
            $table->setRenderer(new \FrenchFrogs\Polliwog\Table\Renderer\Remote());

            $data = [];
            foreach($table->render() as $row){
                $data[] = array_values($row);
            }

            return response()->json(['data' => $data, 'draw' => Input::get('draw'), 'recordsFiltered' => $table->getItemsTotal(), 'recordsTotal' => $table->getItemsTotal()]);

        })->name('datatable');


        Response::macro('modal', function($title, $body = '', $actions  = [])
        {
            if ($title instanceof FrenchFrogs\Polliwog\Modal\Modal\Modal) {
                $modal = $title;
            } elseif($title instanceof FrenchFrogs\Polliwog\Form\Form\Form) {
                $actions = (array) $title->getActions();
                $title->clearActions();

                foreach($actions as $submit) {
                    if ($submit instanceof FrenchFrogs\Polliwog\Form\Element\Submit) {
                        $submit->addAttribute('data-target', '#'.$title->getAttribute('id'))->addClass('form-remote');
                    }
                }

                $modal = modal($title->getLegend(), $title, $actions);
            } else {
                $modal = modal($title, $body, $actions);
            }

            $modal->disableCloseButton();

            // As it's an ajax request, we render only the content
            $modal->enableRemote();
            return $modal;
        });

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
                    $message->from($from)->subject($subject);

                    // Managing multiple to
                    foreach ($to as $mail)      { $message->to($mail); }
                    // Managing multiple attachment
                    foreach ($attach as $file)  { $message->attach($file); }
                });
            }
        });
    }
}