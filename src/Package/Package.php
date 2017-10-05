<?php
/**
 * Created by PhpStorm.
 * User: 20150176
 * Date: 2017/10/05
 * Time: 16:22
 */

namespace nocturne\package;


interface Package
{
    /**
     * Called when the plugin is loaded, before calling onEnable()
     */
    public function onLoad();
    /**
     * Called when the plugin is enabled
     */
    public function onEnable();
    /**
     * @return bool
     */
    public function isEnabled() : bool;
    /**
     * Called when the plugin is disabled
     * Use this to free open things and finish actions
     */
    public function onDisable();
    /**
     * @return bool
     */
    public function isDisabled() : bool;
    /**
     * Gets the plugin's data folder to save files and configuration.
     * This directory name has a trailing slash.
     *
     * @return string
     */
    public function getDataFolder() : string;
    /**
     * Gets an embedded resource in the plugin file.
     *
     * @param string $filename
     *
     * @return
     */
    public function getResource(string $filename);
    /**
     * Saves an embedded resource to its relative location in the data folder
     *
     * @param string $filename
     * @param bool $replace
     *
     * @return bool
     */
    public function saveResource(string $filename, bool $replace = false) : bool;
    /**
     * Returns all the resources packaged with the plugin
     *
     * @return string[]
     */
    public function getResources() : array;
    /**
     * @return bool
     */
    public function saveDefaultConfig() : bool;
    public function reloadConfig();
    /**
     * @return string
     */
    public function getName() : string;

}