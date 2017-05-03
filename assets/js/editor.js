/*
Plugin Name: jQuery Wysiwyg Editor
Plugin URI: http://amfearliath.tk/osclass-jquery-wysiwyg-editor
Description: Add a Wysiwyg Editor to the ad create/edit pages
Version: 1.0.1
Author: Liath
Author URI: http://amfearliath.tk
Short Name: jquery_wysiwyg_editor
Plugin update URI: jquery-wysiwyg-editor


DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
Version 2, December 2004

Copyright (C) 2004 Sam Hocevar
14 rue de Plaisance, 75014 Paris, France
Everyone is permitted to copy and distribute verbatim or modified
copies of this license document, and changing it is allowed as long
as the name is changed.

DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

0. You just DO WHAT THE FUCK YOU WANT TO.
*/
$(document).ready(function () {
    loadEditor("textarea.createNews");
    function loadEditor(el) {
        var jQWE = new Array();
            jQWE.placeholder            = 'Write your news here',
            jQWE.placeholderURL         = 'https://bengoltrader.com',
            jQWE.fonts                  = '1',
            jQWE.trans_fonts            = 'Fonts',
            jQWE.fontsize               = '1',
            jQWE.trans_fontsize         = 'Fontsize',
            jQWE.header                 = '1'
            jQWE.trans_header           = 'Header',
            jQWE.bold                   = '1',
            jQWE.trans_bold             = 'Bold (CTRL + B)',
            jQWE.italic                 = '1',
            jQWE.trans_italic           = 'Italic (CTRL + I)',
            jQWE.underline              = '1',
            jQWE.trans_underline        = 'Underline (CTRL + U)',
            jQWE.strikethrough          = '1',
            jQWE.trans_strikethrough    = 'Strikethrough (CTRL + S)',
            jQWE.link                   = '1',
            jQWE.trans_link             = 'Insert Link',
            jQWE.textcolor              = '1',
            jQWE.trans_textcolor        = 'Textcolor',
            jQWE.bgcolor                = '1',
            jQWE.trans_bgcolor          = 'Backgroundcolor',
            jQWE.alignleft              = '1',
            jQWE.trans_alignleft        = 'Align Left',
            jQWE.alignright             = '1',
            jQWE.trans_alignright       = 'Align Right',
            jQWE.aligncenter            = '1',
            jQWE.trans_aligncenter      = 'Align Center',
            jQWE.alignjustified         = '1',
            jQWE.trans_alignjustified   = 'Justify',
            jQWE.subscript              = '1',
            jQWE.trans_subscript        = 'Subscript',
            jQWE.superscript            = '1',
            jQWE.trans_superscript      = 'Superscript',
            jQWE.indent                 = '1',
            jQWE.trans_indent           = 'Indent',
            jQWE.outdent                = '1',
            jQWE.trans_outdent          = 'Outdent',
            jQWE.ordered                = '1'
            jQWE.trans_ordered          = 'Ordered List',
            jQWE.unordered              = '1',
            jQWE.trans_unordered        = 'Unordered List',
            jQWE.clear                  = '1'; 
            jQWE.trans_clear            = 'Clear Format'; 

        $(el).wysiwyg({
            classes: 'content-editor',
            toolbar: 'top',            
            placeholder: jQWE.placeholder,                                            
            placeholderUrl: jQWE.placeholderURL,
            buttons: {
                fontname: jQWE.fonts != 1 ? false : {
                    title: jQWE.trans_fonts,
                    image: '\uf031',
                    popup: function( $popup, $button ) {
                        var list_fontnames = {
                            'Amatic SC'             : 'Amatic SC',
                            'Architects Daughter'   : 'Architects Daughter',
                            'Arial, Helvetica'      : 'Arial,Helvetica',
                            'Audiowide'             : 'Audiowide',
                            'Bad Script'            : 'Bad Script',
                            'Black Ops One'         : 'Black Ops One',
                            'Calligraffitti'        : 'Calligraffitti',
                            'Cinzel'                : 'Cinzel',
                            'Cinzel Decorative'     : 'Cinzel Decorative',
                            'Codystar'              : 'Codeystar',
                            'Cookie'                : 'Cookie',
                            'Courier New'           : 'Courier New,Courier',
                            'Dancing Script'        : 'Dancing Script',
                            'Dosis'                 : 'Dosis',
                            'Forum'                 : 'Forum',
                            'Fredericka the Great'  : 'Fredericka the Great',
                            'Georgia'               : 'Georgia',
                            'Great Vibes'           : 'Great Vibes',
                            'Handlee'               : 'Handlee',
                            'Josefin Sans'          : 'Josefin Sans',
                            'Josefin Slab'          : 'Josefin Slab',
                            'Kaushan Script'        : 'Kaushan Script',
                            'Lobster Two'           : 'Lobster Two',
                            'Maven Pro'             : 'Maven Pro',
                            'Orbitron'              : 'Orbitron',
                            'Play'                  : 'Play',
                            'Playball'              : 'Playball',
                            'Petit Formal Script'   : 'Petit Formal Script',
                            'Poiret One'            : 'Poiret One',
                            'PT Serif'              : 'PT Serif',
                            'Quicksand'             : 'Quicksand',
                            'Raleway'               : 'Raleway',
                            'Rock Salt'             : 'Rock Salt',
                            'Shadows Into Light'    : 'Shadows Into Light',
                            'Tangerine'             : 'Tangerine',
                            'Times New Roman'       : 'Times New Roman,Times',
                            'Verdana'               : 'Verdana,Geneva',
                            'Vollkorn'              : 'Vollkorn'
                        };
                        var $list = $('<div/>').addClass('wysiwyg-plugin-list')
                        .attr('unselectable','on');
                        $.each( list_fontnames, function( name, font ) {
                            var $link = $('<a/>').attr('href','#')
                            .css( 'font-family', font )
                            .html( name )
                            .click(function(event) {
                                $(element).wysiwyg('shell').fontName(font).closePopup();
                                // prevent link-href-#
                                event.stopPropagation();
                                event.preventDefault();
                                return false;
                            });
                            $list.append( $link );
                        });
                        $popup.append( $list );
                    }        
                },
                fontsize:   jQWE.fontsize != 1 ? false : {
                    title: jQWE.trans_fontsize,
                    image: '\uf034',
                    popup: function( $popup, $button ) {
                        var list_fontsizes = [];
                        for( var i=8; i <= 11; ++i )
                            list_fontsizes.push(i+'px');
                        for( var i=12; i <= 28; i+=2 )
                            list_fontsizes.push(i+'px');
                        list_fontsizes.push('36px');
                        list_fontsizes.push('48px');
                        list_fontsizes.push('72px');
                        var $list = $('<div/>').addClass('wysiwyg-plugin-list')
                        .attr('unselectable','on');
                        $.each( list_fontsizes, function( index, size ) {
                            var $link = $('<a/>').attr('href','#')
                            .html( size )
                            .click(function(event) {
                                $(element).wysiwyg('shell').fontSize(7).closePopup();
                                $(element).wysiwyg('container')
                                .find('font[size=7]')
                                .removeAttr("size")
                                .css("font-size", size);
                                event.stopPropagation();
                                event.preventDefault();
                                return false;
                            });
                            $list.append( $link );
                        });
                        $popup.append( $list );
                    }

                },
                header:  jQWE.header != 1 ? false : {
                    title: jQWE.trans_header,
                    image: '\uf1dc',
                    showstatic: true,    
                    showselection: true,     
                    popup: function( $popup, $button ) {
                        var list_headers = {
                            'Header 1' : '<h1>',
                            'Header 2' : '<h2>',
                            'Header 3' : '<h3>',
                            'Header 4' : '<h4>',
                            'Header 5' : '<h5>',
                            'Header 6' : '<h6>'
                        };
                        var $list = $('<div/>').addClass('wysiwyg-plugin-list')
                        .attr('unselectable','on');
                        $.each( list_headers, function( name, format ) {
                            var $link = $('<a/>').attr('href','#')
                            .css( 'font-family', format )
                            .html( name )
                            .click(function(event) {
                                $(element).wysiwyg('shell').format(format).closePopup();
                                event.stopPropagation();
                                event.preventDefault();
                                return false;
                            });
                            $list.append( $link );
                        });
                        $popup.append( $list );
                    }
                },
                bold: jQWE.bold != 1 ? false : {
                    title: jQWE.trans_bold,
                    image: '\uf032',
                    hotkey: 'b'
                },
                italic: jQWE.italic != 1 ? false : {
                    title: jQWE.trans_italic,
                    image: '\uf033',
                    hotkey: 'i'
                },
                underline: jQWE.underline != 1 ? false : {
                    title: jQWE.trans_underline,
                    image: '\uf0cd',
                    hotkey: 'u'
                },
                strikethrough: jQWE.strikethrough != 1 ? false : {
                    title: jQWE.trans_strikethrough,
                    image: '\uf0cc',
                    hotkey: 's'    
                },
                insertlink: jQWE.link != 1 ? false : {
                    title: jQWE.trans_link,
                    image: '\uf08e'
                },
                forecolor: jQWE.textcolor != 1 ? false : {
                    title: jQWE.trans_textcolor,
                    image: '\uf1fc'    
                },
                highlight: jQWE.bgcolor != 1 ? false : {
                    title: jQWE.trans_bgcolor,
                    image: '\uf043'    
                },
                alignleft: jQWE.alignleft != 1 ? false : {
                    title: jQWE.trans_alignleft,
                    image: '\uf036'    
                },
                aligncenter: jQWE.aligncenter != 1 ? false : {
                    title: jQWE.trans_aligncenter,
                    image: '\uf037'    
                },
                alignright: jQWE.alignright != 1 ? false : {
                    title: jQWE.trans_alignright,
                    image: '\uf038'    
                },
                alignjustify: jQWE.alignjustified != 1 ? false : {
                    title: jQWE.trans_alignjustified,
                    image: '\uf039'    
                },
                subscript: jQWE.subscript != 1 ? false : {
                    title: jQWE.trans_subscript,
                    image: '\uf12c'    
                },
                superscript: jQWE.superscript != 1 ? false : {
                    title: jQWE.trans_superscript,
                    image: '\uf12b'    
                },
                indent: jQWE.indent != 1 ? false : {
                    title: jQWE.trans_indent,
                    image: '\uf03c'    
                },
                outdent: jQWE.outdent != 1 ? false : {
                    title: jQWE.trans_outdent,
                    image: '\uf03b'    
                },
                orderedList: jQWE.ordered != 1 ? false : {
                    title: jQWE.trans_ordered,
                    image: '\uf0cb'    
                },
                unorderedList: jQWE.unordered != 1 ? false : {
                    title: jQWE.trans_unordered,
                    image: '\uf0ca',
                    showstatic: true,    
                    showselection: false    
                },
                removeformat: jQWE.clear != 1 ? false : {
                    title: jQWE.trans_clear,
                    image: '\uf12d'    
                }
            }
        });
    };
});