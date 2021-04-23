<?php

namespace OmniPro\Prueba\Api\Data;

interface BlogInterface
{
    /**
     *  get title blog
     * @return string
     */
    public function getTitle();

    /**
     *  set title blog
     * @param string $title
     * @return void
     */
    public function setTitle($title);

    /**
     * get content blog
     * @return string
     */
    public function getContent();

    /**
     * set content blog
     * @param string $content
     * @return void
     */
    public function setContent($content);

    /**
     * get image blog
     * @return string
     */
    public function getImage();

    /**
     * set image blog
     * @param string $image
     * @return void
     */
    public function setImage($image);

     /**
     * get email blog
     * @return string
     */
    public function getEmail();

    /**
     * set email blog
     * @param string $email
     * @return void
     */
    public function setEmail($image);




}
