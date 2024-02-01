<?php

namespace Imyie\Postcoder\Controller\Suggestions;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\ActionFilter;

use Imyie\Postcoder\Request;

Loc::loadMessages(__FILE__);

class Address extends Controller
{

	const URL = 'https://ws.postcoder.com/pcw/';

    /**
	 * @return array
	 */
	public function configureActions()
	{
		return [
			'getData' => [
				'prefilters' => [
					new ActionFilter\Csrf(),
				],
            ],
		];
    }

	/**
	 * @param string $query
	 * @return array
	 */
	public static function getDataAction(string $query, array $options): array
	{
        if (empty($query)) {
            throw new \Exception(Loc::getMessage('IMTIE_LIB_ADDRESS_EXCEPTION_EMPTY_QUERY'));
        }
	    $url = self::getUrl($query);
		$request = new Request($url);

		$defaultOptions = [
		    'format',
		    'identifier',
		    'lines',
		    'include',
		    'exclude',
		    'addtags',
		    'postcodeonly',
		    'alias',
		    'callback',
		    'page',
        ];

		$fields = [];
		foreach ($defaultOptions as $option) {
            if ('' !== $options[$option]) {
                $fields[$option] = $options[$option];
            }
        }

		if (0 < count($fields)) {
            $request->setData($fields);
        }

		$request->get();

		$result = $request->getResponseArray();

		return [
			'query' => $query,
			'options' => $options,
			'data' => $result,
		];
    }

    public static function getUrl(string $query): string
    {
        $token = Option::get('imyie.postcoder', 'token', '');
        if (empty($token)) {
            throw new \Exception(Loc::getMessage('IMTIE_LIB_ADDRESS_EXCEPTION_EMPTY_TOKEN'));
        }

        return self::URL.'/'.$token.'/address/uk/'.$query;
    }

}
