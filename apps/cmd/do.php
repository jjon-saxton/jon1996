<?php

if (empty($_REQUEST['q']))
    {
        header ("Location: ./");
    }
else
    {
        switch ($_REQUEST['q'])
            {
                case 'navigation': //Start with keywords to forward to pages/sections
                case 'navi':
                case "nav":
                    header ("Location: ../../frames/nav.htm");
                    break;
                case 'news':
                case 'search':
                case 'test':
                    header ("Location: ../../pages/{$_REQUEST['q']}.htm");
                    break;
                case 'help':
                    //TODO show help
                    break;
                default:
                    //TODO parse "q" for interfacing with apps or other commands
            }
    }
