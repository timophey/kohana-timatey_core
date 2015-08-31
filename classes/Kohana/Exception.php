<?php defined('SYSPATH') OR die('No direct script access.');

class Kohana_Exception extends Kohana_Kohana_Exception {
	
		/**
	 * Get a Response object representing the exception
	 *
	 * @uses    Kohana_Exception::text
	 * @param   Exception  $e
	 * @return  Response
	 */
	public static function response(Exception $e)
	{
		try
		{
			// Get the exception information
			$class   = get_class($e);
			$code    = $e->getCode();
			$message = $e->getMessage();
			$file    = $e->getFile();
			$line    = $e->getLine();
			$trace   = $e->getTrace();

			if(Kohana::$environment >= Kohana::DEVELOPMENT){
				// Show the normal Kohana error page.
				return parent::response($e);
			}else{

				$attributes = array(
					'action'=>500
				);
				
				$body = Request::factory(Route::get('error')->uri($attributes))
					->execute()
					->send_headers()
					->body();				
				
				// Prepare the response object.
				$response = Response::factory();

				// Set the response status
				$response->status(($e instanceof HTTP_Exception) ? $e->getCode() : 500);

				// Set the response headers
				$response->headers('Content-Type', Kohana_Exception::$error_view_content_type.'; charset='.Kohana::$charset);

				// Set the response body
				$response->body($body);
			}			
		}
		catch (Exception $e)
		{
			/**
			 * Things are going badly for us, Lets try to keep things under control by
			 * generating a simpler response object.
			 */
			$response = Response::factory();
			$response->status(500);
			$response->headers('Content-Type', 'text/plain');
			$response->body(Kohana_Exception::text($e));
		}

		return $response;
	}

	}
