<template>
    <div class="post-create-zone">
        <checkphone :user="user" :post="post" ref="checkphone"/>

        <form @submit.prevent="sendform">
            <section>
                <div class="edit-wrap-section-place">
                    <div class="container">
                        <div class="wrap-icon1"></div>
                        <div class="container container-two">
                            <h2>¿Dónde quieres anunciarte?</h2>
                            <p class="edit-desc">Introduce tu ciudad</p>
                            <v-select
                                v-model.trim="$v.form.place.$model"
                                :class="{ 'input-error': $v.form.place.$error }"
                                :options="placesoption"
                                :searchable="true"
                                class="style-chooser chooser-full-width"
                                placeholder="Madrid, Barcelona, Barrio Salamanca, ..."
                            />
                            <div class="row">
                                <div class="col-md-12 col-lg-4">
                                    <div class="select-area">
                                        <div class="label-wrap__leftp">
                                            <span class="input-label">Provincia:</span>
                                        </div>
                                        <v-select
                                            v-model.trim="$v.form.province.$model"
                                            :class="{ 'input-error': $v.form.province.$error }"
                                            :options="provinceoption"
                                            :searchable="false"
                                            class="style-chooser"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    <div class="select-area">
                                        <div class="label-wrap__leftp">
                                            <span class="input-label">Población:</span>
                                        </div>
                                        <v-select
                                            v-model.trim="$v.form.town.$model"
                                            :class="{ 'input-error': $v.form.town.$error }"
                                            :options="townoption"
                                            :searchable="false"
                                            class="style-chooser"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    <div class="select-area option-chooser">
                                        <div class="label-wrap__leftp">
                                            <span class="input-label">Zona:</span>
                                        </div>
                                        <input type="text" v-model="form.zona" class="input input-fullwidth"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="edit-wrap-section-body">
                    <div class="container">
                        <div class="wrap-icon2"></div>
                        <div class="container container-two">
                            <h2>Datos del anuncio</h2>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="select-area">
                                        <div class="label-wrap__leftp">
                                            <span class="input-label">Categoría:</span>
                                        </div>
                                        <v-select
                                            :options="cats"
                                            v-model.trim="$v.form.category.$model"
                                            :class="{ 'input-error': $v.form.category.$error }"
                                            class="style-chooser"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="row frow-input-padding">
                                <div class="col-sm-12">
                                    <div class="input-area">
                                        <div class="label-wrap__leftp">
                                            <span class="input-label">Título:</span>
                                        </div>
                                        <input
                                            type="text"
                                            class="input input-fw"
                                            v-model.trim="$v.form.title.$model"
                                            :class="{ 'input-error': $v.form.title.$error }"
                                        />
                                    </div>
                                    <div class="input-area-error">
                                    <span :class="{'access-error': !$v.form.title.$error}">
                                        Llevas {{ form.title.length }} caracteres. El mínimo son 40, el máximo son 50.
                                    </span>
                                    </div>
                                </div>
                            </div>
							<div class="row frow-input-padding">
                                <div class="col-sm-12">
                                    <div class="input-area">
                                        <span class="input-label">&nbsp;</span>
                                        <div class="block-box">
											<span class="input-label-title">Tienes que introducir texto por líneas, cada frase es una nueva línea:</span>
											<div class="input-area">
												<div class="text-right d-flex">
													<span class="input-label">1.&nbsp;&nbsp;</span>
													<span class="input-indicator">
                                                        <div class="input-indicator-box" v-show="!$v.form.text_1.$error && $v.form.text_1.$model.length <= 0">
															<img src="/img/icons/check-empty.svg" />
														</div>
														<div class="input-indicator-box" v-show="!$v.form.text_1.$error && $v.form.text_1.$model.length > 0">
															<img src="/img/icons/check-success.svg" />
														</div>
														<div class="input-indicator-box" v-show="$v.form.text_1.$error">
															<img src="/img/icons/check-fail.svg" />
														</div>
													</span>
												</div>
												<input
													type="text"
													class="input w-100 input-dashed-bottom"
													v-model.trim="$v.form.text_1.$model"
                                                    placeholder="Пример заполнения строки 1"
													:class="{ 'input-error': $v.form.text_1.$error }"
												/>
											</div>
											<div class="input-area">
												<div class="text-right d-flex">
													<span class="input-label">2.&nbsp;&nbsp;</span>
													<span class="input-indicator">
														<div class="input-indicator-box" v-show="!$v.form.text_2.$error && $v.form.text_2.$model.length <= 0">
															<img src="/img/icons/check-empty.svg" />
														</div>
														<div class="input-indicator-box" v-show="!$v.form.text_2.$error && $v.form.text_2.$model.length > 0">
															<img src="/img/icons/check-success.svg" />
														</div>
														<div class="input-indicator-box" v-show="$v.form.text_2.$error">
															<img src="/img/icons/check-fail.svg" />
														</div>
													</span>
												</div>
												<input
													type="text"
													class="input w-100 input-dashed-bottom"
													v-model.trim="$v.form.text_2.$model"
                                                    placeholder="Пример заполнения строки 2"
													:class="{ 'input-error': $v.form.text_2.$error }"
												/>
											</div>
											<div class="input-area">
												<div class="text-right d-flex">
													<span class="input-label">3.&nbsp;&nbsp;</span>
													<span class="input-indicator">
														<div class="input-indicator-box" v-show="!$v.form.text_3.$error && $v.form.text_3.$model.length <= 0">
															<img src="/img/icons/check-empty.svg" />
														</div>
														<div class="input-indicator-box" v-show="!$v.form.text_3.$error && $v.form.text_3.$model.length > 0">
															<img src="/img/icons/check-success.svg" />
														</div>
														<div class="input-indicator-box" v-show="$v.form.text_3.$error">
															<img src="/img/icons/check-fail.svg" />
														</div>
													</span>
												</div>
												<input
													type="text"
													class="input w-100 input-dashed-bottom"
													v-model.trim="$v.form.text_3.$model"
                                                    placeholder="Пример заполнения строки 3"
													:class="{ 'input-error': $v.form.text_3.$error }"
												/>
											</div>
											<div class="input-area">
												<div class="text-right d-flex">
													<span class="input-label">4.&nbsp;&nbsp;</span>
													<span class="input-indicator">
														<div class="input-indicator-box" v-show="!$v.form.text_4.$error && $v.form.text_4.$model.length <= 0">
															<img src="/img/icons/check-empty.svg" />
														</div>
														<div class="input-indicator-box" v-show="!$v.form.text_4.$error && $v.form.text_4.$model.length > 0">
															<img src="/img/icons/check-success.svg" />
														</div>
														<div class="input-indicator-box" v-show="$v.form.text_4.$error">
															<img src="/img/icons/check-fail.svg" />
														</div>
													</span>
												</div>
												<input
													type="text"
													class="input w-100 input-dashed-bottom"
													v-model.trim="$v.form.text_4.$model"
                                                    placeholder="Пример заполнения строки 4"
													:class="{ 'input-error': $v.form.text_4.$error }"
												/>
											</div>
											<div class="input-area">
												<div class="text-right d-flex">
													<span class="input-label">5.&nbsp;&nbsp;</span>
													<span class="input-indicator">
														<div class="input-indicator-box" v-show="!$v.form.text_5.$error && $v.form.text_5.$model.length <= 0">
															<img src="/img/icons/check-empty.svg" />
														</div>
														<div class="input-indicator-box" v-show="!$v.form.text_5.$error && $v.form.text_5.$model.length > 0">
															<img src="/img/icons/check-success.svg" />
														</div>
														<div class="input-indicator-box" v-show="$v.form.text_5.$error">
															<img src="/img/icons/check-fail.svg" />
														</div>
													</span>
												</div>
												<input
													type="text"
													class="input w-100 input-dashed-bottom"
													v-model.trim="$v.form.text_5.$model"
                                                    placeholder="Пример заполнения строки 5"
													:class="{ 'input-error': $v.form.text_5.$error }"
												/>
											</div>
											<div class="input-area">
												<div class="text-right d-flex">
													<span class="input-label">6.&nbsp;&nbsp;</span>
													<span class="input-indicator">
														<div class="input-indicator-box" v-show="!$v.form.text_6.$error && $v.form.text_6.$model.length <= 0">
															<img src="/img/icons/check-empty.svg" />
														</div>
														<div class="input-indicator-box" v-show="!$v.form.text_6.$error && $v.form.text_6.$model.length > 0">
															<img src="/img/icons/check-success.svg" />
														</div>
														<div class="input-indicator-box" v-show="$v.form.text_6.$error">
															<img src="/img/icons/check-fail.svg" />
														</div>
													</span>
												</div>
												<input
													type="text"
													class="input w-100 input-dashed-bottom"
													v-model.trim="$v.form.text_6.$model"
                                                    placeholder="Пример заполнения строки 6"
													:class="{ 'input-error': $v.form.text_6.$error }"
												/>
											</div>
											<div class="input-area">
												<div class="text-right d-flex">
													<span class="input-label">7.&nbsp;&nbsp;</span>
													<span class="input-indicator">
														<div class="input-indicator-box" v-show="!$v.form.text_7.$error && $v.form.text_7.$model.length <= 0">
															<img src="/img/icons/check-empty.svg" />
														</div>
														<div class="input-indicator-box" v-show="!$v.form.text_7.$error && $v.form.text_7.$model.length > 0">
															<img src="/img/icons/check-success.svg" />
														</div>
														<div class="input-indicator-box" v-show="$v.form.text_7.$error">
															<img src="/img/icons/check-fail.svg" />
														</div>
													</span>
												</div>
												<input
													type="text"
													class="input w-100 input-dashed-bottom"
													v-model.trim="$v.form.text_7.$model"
                                                    placeholder="Пример заполнения строки 7"
													:class="{ 'input-error': $v.form.text_7.$error }"
												/>
											</div>
											<div class="input-area">
												<div class="text-right d-flex">
													<span class="input-label">8.&nbsp;&nbsp;</span>
													<span class="input-indicator">
														<div class="input-indicator-box" v-show="!$v.form.text_8.$error && $v.form.text_8.$model.length <= 0">
															<img src="/img/icons/check-empty.svg" />
														</div>
														<div class="input-indicator-box" v-show="!$v.form.text_8.$error && $v.form.text_8.$model.length > 0">
															<img src="/img/icons/check-success.svg" />
														</div>
														<div class="input-indicator-box" v-show="$v.form.text_8.$error">
															<img src="/img/icons/check-fail.svg" />
														</div>
													</span>
												</div>
												<input
													type="text"
													class="input w-100 input-dashed-bottom"
													v-model.trim="$v.form.text_8.$model"
                                                    placeholder="Пример заполнения строки 8"
													:class="{ 'input-error': $v.form.text_8.$error }"
												/>
											</div>
											<div class="input-area">
												<div class="text-right d-flex">
													<span class="input-label">9.&nbsp;&nbsp;</span>
													<span class="input-indicator">
														<div class="input-indicator-box" v-show="!$v.form.text_9.$error && $v.form.text_9.$model.length <= 0">
															<img src="/img/icons/check-empty.svg" />
														</div>
														<div class="input-indicator-box" v-show="!$v.form.text_9.$error && $v.form.text_9.$model.length > 0">
															<img src="/img/icons/check-success.svg" />
														</div>
														<div class="input-indicator-box" v-show="$v.form.text_9.$error">
															<img src="/img/icons/check-fail.svg" />
														</div>
													</span>
												</div>
												<input
													type="text"
													class="input w-100 input-dashed-bottom"
													v-model.trim="$v.form.text_9.$model"
                                                    placeholder="Пример заполнения строки 9"
													:class="{ 'input-error': $v.form.text_9.$error }"
												/>
											</div>
											<div class="input-area">
												<div class="text-right d-flex">
													<span class="input-label">10.</span>
													<span class="input-indicator">
                                                        <div class="input-indicator-box" v-show="!$v.form.text_10.$error && $v.form.text_10.$model.length <= 0">
															<img src="/img/icons/check-empty.svg" />
														</div>
														<div class="input-indicator-box" v-show="!$v.form.text_10.$error && $v.form.text_10.$model.length > 0">
															<img src="/img/icons/check-success.svg" />
														</div>
														<div class="input-indicator-box" v-show="$v.form.text_10.$error">
															<img src="/img/icons/check-fail.svg" />
														</div>
													</span>
												</div>
												<input
													type="text"
													class="input w-100 input-dashed-bottom"
													v-model.trim="$v.form.text_10.$model"
                                                    placeholder="Пример заполнения строки 10"
													:class="{ 'input-error': $v.form.text_10.$error }"
												/>
											</div>
											<!--div class="input-area-error" v-show="!$v.form.text.$error">
												<span :class="{'access-error': !$v.form.text.$error}">
													Llevas {{ form.text.length }} caracteres. El mínimo son 300, el máximo son 1000.
												</span>
											</div-->
											<div class="input-area-error" v-show="$v.form.text_1.$error">
												<span :class="{'access-error': !$v.form.text_1.$error}">
													Línea 1: Llevas {{ form.text_1.length }} caracteres. El mínimo son 30, el máximo son 100.
												</span>
											</div>
											<div class="input-area-error" v-show="$v.form.text_2.$error">
												<span :class="{'access-error': !$v.form.text_2.$error}">
													Línea 2: Llevas {{ form.text_2.length }} caracteres. El mínimo son 30, el máximo son 100.
												</span>
											</div>
											<div class="input-area-error" v-show="$v.form.text_3.$error">
												<span :class="{'access-error': !$v.form.text_3.$error}">
													Línea 3: Llevas {{ form.text_3.length }} caracteres. El mínimo son 30, el máximo son 100.
												</span>
											</div>
											<div class="input-area-error" v-show="$v.form.text_4.$error">
												<span :class="{'access-error': !$v.form.text_4.$error}">
													Línea 4: Llevas {{ form.text_4.length }} caracteres. El mínimo son 30, el máximo son 100.
												</span>
											</div>
											<div class="input-area-error" v-show="$v.form.text_5.$error">
												<span :class="{'access-error': !$v.form.text_5.$error}">
													Línea 5: Llevas {{ form.text_5.length }} caracteres. El mínimo son 30, el máximo son 100.
												</span>
											</div>
											<div class="input-area-error" v-show="$v.form.text_6.$error">
												<span :class="{'access-error': !$v.form.text_6.$error}">
													Línea 6: Llevas {{ form.text_6.length }} caracteres. El mínimo son 30, el máximo son 100.
												</span>
											</div>
											<div class="input-area-error" v-show="$v.form.text_7.$error">
												<span :class="{'access-error': !$v.form.text_7.$error}">
													Línea 7: Llevas {{ form.text_7.length }} caracteres. El mínimo son 30, el máximo son 100.
												</span>
											</div>
											<div class="input-area-error" v-show="$v.form.text_8.$error">
												<span :class="{'access-error': !$v.form.text_8.$error}">
													Línea 8: Llevas {{ form.text_8.length }} caracteres. El mínimo son 30, el máximo son 100.
												</span>
											</div>
											<div class="input-area-error" v-show="$v.form.text_9.$error">
												<span :class="{'access-error': !$v.form.text_9.$error}">
													Línea 9: Llevas {{ form.text_9.length }} caracteres. El mínimo son 30, el máximo son 100.
												</span>
											</div>
											<div class="input-area-error" v-show="$v.form.text_10.$error">
												<span :class="{'access-error': !$v.form.text_10.$error}">
													Línea 10: Llevas {{ form.text_10.length }} caracteres. El mínimo son 30, el máximo son 100.
												</span>
											</div>
										</div>
                                    </div>
                                </div>
                            </div>
	
                            <div class="row frow-input-padding">
                                <div class="col-sm-12">
                                    <div class="input-area">
                                        <div class="label-wrap__leftp">
                                            <span class="input-label">Nombre:</span>
                                        </div>
                                        <input
                                            type="text"
                                            class="input input-fw"
                                            v-model.trim="$v.form.name.$model"
                                            :class="{ 'input-error': $v.form.name.$error }"
                                        />
                                    </div>
                                    <div class="input-area-error">
                                    <span :class="{'access-error': !$v.form.name.$error}">
                                        Llevas {{ form.name.length }} caracteres. El mínimo son 2, el máximo son 15.
                                    </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="select-area">
                                        <div class="label-wrap__leftp">
                                            <span class="input-label">Edad:</span>
                                        </div>
                                        <v-select
                                            :options="ages"
                                            :searchable="true"
                                            class="style-chooser"
                                            v-model.trim="$v.form.age.$model"
                                            :class="{ 'input-error': $v.form.age.$error }"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-area input-area-with-start">
                                        <div class="label-wrap__leftp">
                                            <span class="input-label">WhatsApp</span>
                                        </div>

                                        <div class="whats-app_desc">
                                            <img src="/img/whatsapp.png" alt="whatsapp" class="icon-whats-app"/>
                                            <div class="custom-control custom-checkbox">
                                                <input
                                                    type="checkbox"
                                                    class="custom-control-input"
                                                    id="whatsapp"
                                                    v-model="form.whatsapp"
                                                />
                                                <label class="custom-control-label semibold" for="whatsapp">
                                                    Indicar a los clientes que me pueden contactar por WhatsApp
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="edit-wrap-section-tarif">
                    <div class="container">
                        <div class="wrap-icon3"></div>
                        <div class="container container-two">
                            <h2>Tarifas</h2>
                            <div class="tarifform">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="table-desc">Descripción</div>
                                    </div>
                                    <div class="col-5">
                                        <div class="table-desc">Precio en euros</div>
                                    </div>
                                </div>
                                <div
                                    class="row tarif-input-area"
                                    v-for="(rate, index) in  $v.form.rates.$each.$iter"
                                    :key="index + 'rate'"
                                    :class="{ 'form-group-rate__error': rate.$error }"
                                >
                                    <div class="col-7">
                                        <input
                                            type="text"
                                            class="input input-fullwidth input-rates"
                                            v-model.trim="rate.title.$model"
                                            :class="{ 'input-error': rate.title.$error }"
                                            :disabled="true"
                                        />
                                    </div>
                                    <div class="col-5 col-lg-3">
                                        <div class="quit-area">
                                            <div class="input-with-dis">
                                                <input
                                                    type="text"
                                                    min="0"
                                                    class="input"
                                                    v-model.trim="rate.price.$model"
                                                    v-mask="'######'"
                                                    :class="{ 'input-error': rate.price.$error }"
                                                />
                                            </div>
                                            <!-- <img src="/img/quit.svg" alt="quit" class="quit" @click="removeRate(index)" v-if="index > 1" /> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="wrap-all-btn">
                                    <!-- <button
                                      type="button"
                                      class="btn btn-normal btn_green-hover non-fixed-btn4"
                                      @click="addrate"
                                    >
                                      <div>
                                        <img src="/img/plus.svg" alt="svg" />
                                        <span>crear nuevo</span>
                                      </div>
                                    </button>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="edit-wrap-section-horario">
                    <div class="container">
                        <div class="wrap-icon4"></div>
                        <div class="container container-two">
                            <h2>Horario</h2>
                            <div class="horario-wrap">
                                <div class="custom-control custom-radio">
                                    <input
                                        type="radio"
                                        id="customRadio1"
                                        name="customRadio"
                                        v-model="form.worktime"
                                        :value="'Mañana (10:00 - 22:00)'"
                                        class="custom-control-input"
                                    />
                                    <label
                                        class="custom-control-label semibold radio-padd"
                                        for="customRadio1"
                                    >Mañana (10:00 - 22:00)</label>
                                </div>
                                <div class="custom-control custom-radio center-radio">
                                    <input
                                        type="radio"
                                        id="customRadio2"
                                        name="customRadio"
                                        v-model="form.worktime"
                                        :value="'Tarde (22:00 - 10:00)'"
                                        class="custom-control-input"
                                    />
                                    <label
                                        class="custom-control-label semibold radio-padd"
                                        for="customRadio2"
                                    >Tarde (22:00 - 10:00)</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input
                                        type="radio"
                                        id="customRadio3"
                                        name="customRadio"
                                        v-model="form.worktime"
                                        class="custom-control-input"
                                        :value="'24 Horas'"
                                    />
                                    <label
                                        class="custom-control-label semibold radio-padd"
                                        for="customRadio3"
                                    >24 Horas</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <photo :csrf="csrf" :post="post"></photo>

            <videoupload :csrf="csrf" :post="post"></videoupload>

            <section>
                <div class="edit-wrap-section-sobre">
                    <div class="container">
                        <div class="wrap-icon7"></div>
                        <div class="container container-two">
                            <h2>Sobre ti</h2>
                            <div class="sobre-wrapper">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div
                                            class="radio-wrap-area radio-wrap-area-editer"
                                            v-for="(sobre, index) in form.sobres.slice(0, 6)"
                                            :key="index + '-sobre1'"
                                        >
                                            <label
                                                class="custom-control custom-radio"
                                                :class="{'pink-activ': (sobre.active == true)}"
                                            >
                                                <input
                                                    type="checkbox"
                                                    :id="'sobre' + index"
                                                    :name="sobre.group"
                                                    v-model="sobre.active"
                                                    class="custom-control-input"
                                                    @click="uncheck(sobre.name)"
                                                />
                                                <span class="custom-control-label" :for="'sobre' + index">
                          {{ sobre.name }}
                          <img
                              class="arrow-down"
                              v-if="sobre.options.length > 0"
                              src="/img/down.svg"
                              width="20"
                              alt="down"
                          />
                        </span>
                                            </label>
                                            <div
                                                class="custom-options-wrapper"
                                                v-if="(sobre.options.length > 0) && (sobre.active)"
                                            >
                                                <div class="option-border-left">
                                                    <div
                                                        class="radio-wrap-area"
                                                        v-for="(option, index1) in sobre.options"
                                                        :key="index1 + '-option1'"
                                                    >
                                                        <label
                                                            class="custom-control custom-radio"
                                                            :class="{'pink-activ': (option.active == true)}"
                                                        >
                                                            <input
                                                                :name="sobre.group"
                                                                type="checkbox"
                                                                :id="'option1' + index1"
                                                                v-model="option.active"
                                                                class="custom-control-input"
                                                                @click="uncheckOp(option.name, sobre.name)"
                                                            />
                                                            <span
                                                                class="custom-control-label"
                                                                :for="'option1' + index1"
                                                            >{{ option.name }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div
                                            class="radio-wrap-area radio-wrap-area-editer"
                                            v-for="(sobre, index) in form.sobres.slice(6, 12)"
                                            :key="index + '-sobre2'"
                                        >
                                            <label
                                                class="custom-control custom-radio"
                                                :class="{'pink-activ': (sobre.active == true)}"
                                            >
                                                <input
                                                    type="checkbox"
                                                    :id="'sobre' + index"
                                                    :name="sobre.group"
                                                    v-model="sobre.active"
                                                    class="custom-control-input"
                                                    @click="uncheck(sobre.name)"
                                                />
                                                <span class="custom-control-label" :for="'sobre' + index">
                          {{ sobre.name }}
                          <img
                              class="arrow-down"
                              v-if="sobre.options.length > 0"
                              src="/img/down.svg"
                              width="20"
                              alt="down"
                          />
                        </span>
                                            </label>
                                            <div
                                                class="custom-options-wrapper"
                                                v-if="(sobre.options.length > 0) && (sobre.active)"
                                            >
                                                <div class="option-border-left">
                                                    <div
                                                        class="radio-wrap-area"
                                                        v-for="(option, index2) in sobre.options"
                                                        :key="index2 + '-option2'"
                                                    >
                                                        <label
                                                            class="custom-control custom-radio"
                                                            :class="{'pink-activ': (option.active == true)}"
                                                        >
                                                            <input
                                                                type="checkbox"
                                                                :id="'option2' + index2"
                                                                v-model="option.active"
                                                                :name="sobre.group"
                                                                class="custom-control-input"
                                                                @click="uncheckOp(option.name, sobre.name)"
                                                            />
                                                            <span
                                                                class="custom-control-label"
                                                                :for="'option2' + index2"
                                                            >{{ option.name }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div
                                            class="radio-wrap-area radio-wrap-area-editer"
                                            v-for="(sobre, index) in form.sobres.slice(12, 19)"
                                            :key="index + '-sobre3'"
                                        >
                                            <label
                                                class="custom-control custom-radio"
                                                :class="{'pink-activ': (sobre.active == true) || sobre.options.find(elem => {return elem.active == true})}"
                                            >
                                                <input
                                                    type="checkbox"
                                                    :id="'sobre' + index"
                                                    :name="sobre.group"
                                                    v-model="sobre.active"
                                                    class="custom-control-input"
                                                    @click="uncheck(sobre.name)"
                                                />
                                                <span class="custom-control-label" :for="'sobre' + index">
                          {{ sobre.name }}
                          <img
                              class="arrow-down"
                              v-if="sobre.options.length > 0"
                              src="/img/down.svg"
                              width="20"
                              alt="down"
                          />
                        </span>
                                            </label>
                                            <div
                                                class="custom-options-wrapper"
                                                v-show="(sobre.options.length > 0) && (sobre.active)"
                                            >
                                                <div class="option-border-left">
                                                    <div
                                                        class="radio-wrap-area"
                                                        v-for="(option, index3) in sobre.options"
                                                        :key="index3 + '-option3'"
                                                    >
                                                        <label
                                                            class="custom-control custom-radio"
                                                            :class="{'pink-activ': (option.active == true)}"
                                                        >
                                                            <input
                                                                type="checkbox"
                                                                :id="'option3' + index3"
                                                                :name="sobre.group"
                                                                v-model="option.active"
                                                                class="custom-control-input"
                                                                @click="uncheckOp(option.name, sobre.name)"
                                                            />
                                                            <span
                                                                class="custom-control-label"
                                                                :for="'option3' + index3"
                                                            >{{ option.name }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="input-area-error">
                                <span :class="{'access-error': isSobres}">
                                    Ha seleccionado {{sobresCount}}, mínimo 4
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="edit-wrap-section-sobre edit-wrap-section-serv">
                    <div class="container">
                        <div class="wrap-icon7"></div>
                        <div class="container container-two">
                            <h2>Servicios</h2>
                            <div class="sobre-wrapper">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div
                                            class="radio-wrap-area radio-wrap-area-editer"
                                            v-for="(service, index) in form.services.slice(0, 4)"
                                            :key="index + '-service1'"
                                        >
                                            <label
                                                class="custom-control custom-radio"
                                                :class="{'pink-activ': (service.active == true)}"
                                            >
                                                <input
                                                    type="checkbox"
                                                    :id="'service' + index"
                                                    v-model="service.active"
                                                    @click="uncheck2(service.name)"
                                                    :name="service.group"
                                                    class="custom-control-input"
                                                />
                                                <span class="custom-control-label" :for="'service' + index">
                          {{ service.name }}
                          <img
                              class="arrow-down"
                              v-if="service.options.length > 0"
                              src="/img/down.svg"
                              width="20"
                              alt="down"
                          />
                        </span>
                                            </label>
                                            <div
                                                class="custom-options-wrapper"
                                                v-if="(service.options.length > 0) && (service.active)"
                                            >
                                                <div class="option-border-left">
                                                    <div
                                                        class="radio-wrap-area"
                                                        v-for="(option, index1) in service.options"
                                                        :key="index1 + '-option1'"
                                                    >
                                                        <label
                                                            class="custom-control custom-radio"
                                                            :class="{'pink-activ': (option.active == true)}"
                                                        >
                                                            <input
                                                                type="checkbox"
                                                                :id="'option1' + index1"
                                                                v-model="option.active"
                                                                :name="option.group"
                                                                @click="uncheckOp2(option.name, service.name)"
                                                                class="custom-control-input"
                                                            />
                                                            <span
                                                                class="custom-control-label"
                                                                :for="'option1' + index1"
                                                            >{{ option.name }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div
                                            class="radio-wrap-area radio-wrap-area-editer"
                                            v-for="(service, index) in form.services.slice(4, 8)"
                                            :key="index + '-service2'"
                                        >
                                            <label
                                                class="custom-control custom-radio"
                                                :class="{'pink-activ': (service.active == true)}"
                                            >
                                                <input
                                                    type="checkbox"
                                                    :id="'service' + index"
                                                    v-model="service.active"
                                                    class="custom-control-input"
                                                    :name="service.group"
                                                    @click="uncheck2(service.name)"
                                                />
                                                <span class="custom-control-label" :for="'service' + index">
                          {{ service.name }}
                          <img
                              class="arrow-down"
                              v-if="service.options.length > 0"
                              src="/img/down.svg"
                              width="20"
                              alt="down"
                          />
                        </span>
                                            </label>
                                            <div
                                                class="custom-options-wrapper"
                                                v-if="(service.options.length > 0) && (service.active)"
                                            >
                                                <div class="option-border-left">
                                                    <div
                                                        class="radio-wrap-area"
                                                        v-for="(option, index2) in service.options"
                                                        :key="index2 + '-option2'"
                                                    >
                                                        <label
                                                            class="custom-control custom-radio"
                                                            :class="{'pink-activ': (option.active == true)}"
                                                        >
                                                            <input
                                                                type="checkbox"
                                                                :id="'option2' + index2"
                                                                :name="option.group"
                                                                v-model="option.active"
                                                                class="custom-control-input"
                                                                @click="uncheckOp2(option.name, service.name)"
                                                            />
                                                            <span
                                                                class="custom-control-label"
                                                                :for="'option2' + index2"
                                                            >{{ option.name }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div
                                            class="radio-wrap-area radio-wrap-area-editer"
                                            v-for="(service, index) in form.services.slice(8, 11)"
                                            :key="index + '-service3'"
                                            v-if="(service.group != 'groupz10') || (form.category == 'Travesti')"
                                        >
                                            <label
                                                class="custom-control custom-radio"
                                                :class="{'pink-activ': (service.active == true) || service.options.find(elem => {return elem.active == true})}"
                                            >
                                                <input
                                                    type="checkbox"
                                                    :id="'service' + index"
                                                    v-model="service.active"
                                                    class="custom-control-input"
                                                    :name="service.group"
                                                    @click="uncheck2(service.name)"
                                                />
                                                <span class="custom-control-label" :for="'service' + index">
                          {{ service.name }}
                          <img
                              class="arrow-down"
                              v-if="service.options.length > 0"
                              src="/img/down.svg"
                              width="20"
                              alt="down"
                          />
                        </span>
                                            </label>
                                            <div
                                                class="custom-options-wrapper sdf4"
                                                v-show="(service.options.length > 0) && (service.active)"
                                            >
                                                <div class="option-border-left">
                                                    <div
                                                        class="radio-wrap-area"
                                                        v-for="(option, index3) in service.options"
                                                        :key="index3 + '-option3'"
                                                    >
                                                        <label
                                                            class="custom-control custom-radio"
                                                            :class="{'pink-activ': (option.active == true)}"
                                                        >
                                                            <input
                                                                type="checkbox"
                                                                :id="'option3' + index3"
                                                                v-model="option.active"
                                                                class="custom-control-input"
                                                                :name="option.group"
                                                                @click="uncheckOp2(option.name, service.name)"
                                                            />
                                                            <span
                                                                class="custom-control-label"
                                                                :for="'option3' + index3"
                                                            >{{ option.name }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="input-area-error">
                                <span :class="{'access-error': isServices}">
                                    Ha seleccionado {{servicesCount}}, mínimo 2
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!--section>
                <div class="section-edit-map">
                    <div class="container">
                        <div class="wrap-icon8"></div>
                        <div class="container container-two">
                            <h2>Mapa</h2>
                            <div class="map-wrapper">
                                <div class="map-desc">
                                    <p>
                                        Para facilitar que tus clientes encuentren tu apartamento o local puedes mostrar
                                        en
                                        tu
                                        anuncio un mapa con tu ubicación.
                                        Ejemplos: Gran Via con Calle San Bernardo, Calle de Goya 125; Avenida de Francia
                                        34;
                                        etc.
                                    </p>
                                </div>
                                <div class="map-input" style="position: relative;">
                                    <gmap-autocomplete
                                        @place_changed="setNewPlace"
                                        :value="form.currentPlace"
                                    ></gmap-autocomplete>

                                    <button
                                        class="btn btn-normal btn_green-hover non-fixed-btn7"
                                        @click="addMarker"
                                        type="button"
                                    >
                                        <div>
                                            <span data-v-a2b1d1be>Mostrar mapa</span>
                                        </div>
                                    </button>
                                </div>
                                <div class="map-area" :options="mapstyles">
                                    <GmapMap
                                        :center="center"
                                        :zoom="zoom"
                                        map-type-id="terrain"
                                        style="width: 100%; height: 100%"
                                    >
                                        <GmapMarker
                                            :key="index"
                                            v-for="(m, index) in markers"
                                            :position="m.position"
                                            :clickable="true"
                                            :draggable="false"
                                            @click="center=m.position"
                                            :options="{fields: ['geometry']}"
                                        />
                                    </GmapMap>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section-->

            <div class="faux-borders-2"></div>
            <section class="mt-3">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="select-area">
                            <div class="label-wrap__leftp">
                                <span class="input-label">Categoria Pasion.com:</span>
                            </div>
                            <v-select
                                :options="catspasion"
                                v-model.trim="categorypasion"
                                class="style-chooser"
                            />
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <h6>НЕПУБЛИКОВАТЬ</h6>
                <ul class="mt-3" style="font-size:16px;">
                    <li class="mt-3">
                        <select v-model="status_mileroticos">
                            <option value="active">active</option>
                            <option v-for="status in statuses" :value="status.code">{{status.code}}</option>
                        </select>
                        - Mileroticos
                    </li>
                    <li class="mt-3">
                        <select v-model="status_adultguia">
                            <option value="active">active</option>
                            <option v-for="status in statuses" :value="status.code">{{status.code}}</option>
                        </select>
                        - Adultguia
                    </li>
                    <li class="mt-3">
                        <select v-model="status_sustitutas">
                            <option value="active">active</option>
                            <option v-for="status in statuses" :value="status.code">{{status.code}}</option>
                        </select>
                        - Sustitutas
                    </li>
                    <li class="mt-3">
                        <select v-model="status_erosguia">
                            <option value="active">active</option>
                            <option v-for="status in statuses" :value="status.code">{{status.code}}</option>
                        </select>
                        - Erosguia
                    </li>
                    <li class="mt-3">
                        <select v-model="status_slumi">
                            <option value="active">active</option>
                            <option v-for="status in statuses" :value="status.code">{{status.code}}</option>
                        </select>
                        - Slumi
                    </li>
                    <li class="mt-3">
                        <select v-model="status_nuevoloquo">
                            <option value="active">active</option>
                            <option v-for="status in statuses" :value="status.code">{{status.code}}</option>
                        </select>
                        - Nuevoloquo
                    </li>
                </ul>
            </section>
            <section class="mt-3">
                <div class="edit-submit-section">
                    <div class="container">
                        <div class="container container-two d-flex pt-5">
                            <button type="submit" class="btn-form btn-form__cancle btn-form__withicon">
                                <div>
                                    <img src="/img/save.svg" alt="icon"/>
                                    <span>guardar cambios</span>
                                </div>
                            </button>
                            <button type="button" class="btn-form btn-form__cancle btn-form__withicon btn_approve ml-5" v-on:click="toApprove">
                                <div>
                                    <img src="/img/save.svg" alt="icon"/>
                                    <span>aprobar</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>
</template>

<script>
    import {maxLength, minLength, minValue, numeric, required} from "vuelidate/lib/validators";
    import Notify from "./Notify";
    import Mapstyles from "../mapstyle";
    import Sobre from "./Sobre.js";
    import Services from "./Services.js";

    export default {
        props: [
            "user",
            "cats",
            "catspasion",
            "post",
            "oldrates",
            "oldservices",
            "oldremains",
            "places",
            "statuses",
            "currenttariffs",
            "edit"
        ],
        data() {
            return {
                categorypasion: '',
                status_mileroticos: '',
                status_adultguia: '',
                status_sustitutas: '',
                status_erosguia: '',
                status_nuevoloquo: '',
                status_slumi: '',
                ages: _.range(18, 91, 1),
                mapstyles: Mapstyles,
                center: {lat: 40.416775, lng: -3.70379},
                zoom: 7,
                markers: [],
                newplaces: [],
                seplaces: this.places,
                currentPlace: null,
                form: {
                    edit: this.edit,
                    currentPlace: this.post.map ? this.post.map : "",
                    town: this.post.town ? this.post.town : "",
                    province: this.post.province ? this.post.province : "",
                    place: this.post.place ? this.post.place : "",
                    post_id: this.post.id,
                    rates: [
                        {
                            title: "30 Minutos",
                            price: 0
                        },
                        {
                            title: "1 Hora",
                            price: 0
                        },
                        {
                            title: "2 Horas",
                            price: 0
                        },
                        {
                            title: "Noche",
                            price: 0
                        }
                    ],
                    worktime: this.post.worktime,
                    category: this.post.category,
                    title: this.post.title ? this.post.title : "",
                    text: this.post.text ? this.post.text : "",
					text_1: "",
					text_2: "",
					text_3: "",
					text_4: "",
					text_5: "",
					text_6: "",
					text_7: "",
					text_8: "",
					text_9: "",
					text_10: "",
                    name: this.post.name ? this.post.name : "",
                    age: this.post.age,
                    whatsapp: this.post.whatsapp,
                    services: Services.serv,
                    sobres: Sobre.sobr
                },
                csrf: document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content")
            };
        },
        validations: {
            form: {
                town: {
                    required
                },
                province: {
                    required
                },
                place: {
                    required
                },
                rates: {
                    required,
                    // minLength: minLength(1),
                    $each: {
                        title: {
                            required,
                            minLength: minLength(2),
                            maxLength: maxLength(50)
                        },
                        price: {
                            required,
                            minValue: minValue(1), // TODO > 20
                            numeric
                        }
                    }
                },
                category: {
                    required
                },
                title: {
                    required,
                    minLength: minLength(40),
                    maxLength: maxLength(50)
                },
				// TODO
                /*text: {
                    required,
                    minLength: minLength(300),
                    maxLength: maxLength(1000)
                },*/
				text_1: {
                    required,
                    minLength: minLength(30),
                    maxLength: maxLength(100)
                },
				text_2: {
                    required,
                    minLength: minLength(30),
                    maxLength: maxLength(100)
                },
				text_3: {
                    required,
                    minLength: minLength(30),
                    maxLength: maxLength(100)
                },
				text_4: {
                    required,
                    minLength: minLength(30),
                    maxLength: maxLength(100)
                },
				text_5: {
                    required,
                    minLength: minLength(30),
                    maxLength: maxLength(100)
                },
				text_6: {
                    required,
                    minLength: minLength(30),
                    maxLength: maxLength(100)
                },
				text_7: {
                    required,
                    minLength: minLength(30),
                    maxLength: maxLength(100)
                },
				text_8: {
                    required,
                    minLength: minLength(30),
                    maxLength: maxLength(100)
                },
				text_9: {
                    required,
                    minLength: minLength(30),
                    maxLength: maxLength(100)
                },
				text_10: {
                    required,
                    minLength: minLength(30),
                    maxLength: maxLength(100)
                },
                name: {
                    required,
                    minLength: minLength(2),
                    maxLength: maxLength(15)
                },
                age: {
                    required
                }
            }
        },
        watch: {
			"form.title": function(val) {
				this.form.title = this.filterLatinSymbols(val);
                this.$v.form.title.$model = this.form.title;
			},
			"form.name": function(val) {
				this.form.name = this.filterLatinSymbols(val);
                this.$v.form.name.$model = this.form.name;
			},
            "form.text_1": function(val) {
				this.form.text_1 = this.filterLatinSymbolsAndSetText(val);
                this.$v.form.text_1.$model = this.form.text_1;
			},
            "form.text_2": function(val) {
				this.form.text_2 = this.filterLatinSymbolsAndSetText(val);
			},
            "form.text_3": function(val) {
				this.form.text_3 = this.filterLatinSymbolsAndSetText(val);
			},
            "form.text_4": function(val) {
				this.form.text_4 = this.filterLatinSymbolsAndSetText(val);
			},
            "form.text_5": function(val) {
				this.form.text_5 = this.filterLatinSymbolsAndSetText(val);
			},
            "form.text_6": function(val) {
				this.form.text_6 = this.filterLatinSymbolsAndSetText(val);
			},
            "form.text_7": function(val) {
				this.form.text_7 = this.filterLatinSymbolsAndSetText(val);
			},
            "form.text_8": function(val) {
				this.form.text_8 = this.filterLatinSymbolsAndSetText(val);
			},
            "form.text_9": function(val) {
				this.form.text_9 = this.filterLatinSymbolsAndSetText(val);
			},
            "form.text_10": function(val) {
				this.form.text_10 = this.filterLatinSymbolsAndSetText(val);
                this.$v.form.text_10.$model = this.form.text_10;
			},
            "form.place": function (val) {
                if (val != null) {
                    for (var i in this.places) {
                        if (this.places[i].string == val) {
                            this.form.town = this.places[i].town;
                            this.form.province = this.places[i].province;
                        }
                    }
                }
            },
            "form.town": function (val) {
                if (val == null) {
                    this.form.town = "";
                } else {
                    if (this.form.province != "") {
                        const ob_place = this.places.find(elem => {
                            return (
                                elem.province == this.form.province && elem.town == this.form.town
                            );
                        });

                        this.form.place = ob_place.string;
                    }
                }
            },
            "form.province": function (val) {
                if (val == null) {
                    this.form.province = "";
                } else {
                    if (this.form.town != "") {
                        const ob_place = this.places.find(elem => {
                            return (
                                elem.province == this.form.province && elem.town == this.form.town
                            );
                        });

                        this.form.place = ob_place.string;
                    }
                }
            }
        },
        methods: {
            filterLatinSymbolsAndSetText(value)
            {
                // console.log(value)
                // value = this.filterLatinSymbols(value);
                this.setText();
                // console.log(value)
                return value;
            },
			filterLatinSymbols(value)
			{
				const regex = /[^a-zA-Zñáéíóúü0-9 \.\-\_\;\!\?]+/g;
                value = value.replaceAll(regex, '');

                /*0const phoneRegex = /[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}/im;
                value = value.replaceAll(phoneRegex, '');*/
                value = value.trim()
                value = value.toLocaleLowerCase()
                value = value.charAt(0).toUpperCase() + value.slice(1);
				return value;
			},
            setText(){
                let fullText = []

                for(let i = 1; i < 11; i++)
                {
                    let key = 'text_' + (i).toString()

                    if(this.form[key] != undefined)
					{
						let stringValue = this.filterLatinSymbols(this.form[key]);
						// this.form[key] = stringValue.charAt(0).toUpperCase() + stringValue.slice(1);
						fullText.push(this.form[key])
					}
                }
                this.form.text = fullText.join("###")
            },
            uncheck(name) {
                this.form.sobres.filter(elem => {
                    if (elem.options.length > 0 && elem.name != name) {
                        elem.active = false;
                    }
                });

                const sob = this.form.sobres.find(elem => {
                    return elem.name == name;
                });
                this.form.sobres.filter(elem => {
                    if (elem.group == sob.group) {
                        elem.active = false;
                    }
                    if (elem.name == sob.name) {
                        if (sob.active == true) {
                            elem.active = false;
                        } else {
                            elem.active = true;
                        }
                    }
                });
            },
            uncheckOp(name, sobname) {
                const sob1 = this.form.sobres.find(elem => {
                    return elem.name == sobname;
                });
                const sob = sob1.options.find(elem => {
                    return elem.name == name;
                });
                sob1.options.filter(elem => {
                    if (elem.group == sob.group) {
                        elem.active = false;
                    }
                    if (elem.name == sob.name) {
                        if (sob.active == true) {
                            elem.active = false;
                        } else {
                            elem.active = true;
                        }
                    }
                });
            },
            uncheck2(name) {
                this.form.services.filter(elem => {
                    if (elem.options.length > 0 && elem.name != name) {
                        elem.active = false;
                    }
                });

                const sob = this.form.services.find(elem => {
                    return elem.name == name;
                });
                this.form.services.filter(elem => {
                    if (elem.group == sob.group) {
                        elem.active = false;
                    }
                    if (elem.name == sob.name) {
                        if (sob.active == true) {
                            elem.active = false;
                        } else {
                            elem.active = true;
                        }
                    }
                });
            },
            uncheckOp2(name, sobname) {
                const sob1 = this.form.services.find(elem => {
                    return elem.name == sobname;
                });
                const sob = sob1.options.find(elem => {
                    return elem.name == name;
                });
                sob1.options.filter(elem => {
                    if (elem.group == sob.group) {
                        elem.active = false;
                    }
                    if (elem.name == sob.name) {
                        if (sob.active == true) {
                            elem.active = false;
                        } else {
                            elem.active = true;
                        }
                    }
                });
            },
            setNewPlace(place) {
                console.log(place + "asdasd");
                this.form.currentPlace = place.formatted_address;
                this.currentPlace = place;
                this.zoom = 16;
            },
            addMarker() {
                if (this.currentPlace) {
                    const marker = {
                        lat: this.currentPlace.geometry.location.lat(),
                        lng: this.currentPlace.geometry.location.lng()
                    };
                    this.markers.push({position: marker});
                    this.newplaces.push(this.currentPlace);
                    this.center = marker;
                    // this.currentPlace = null;
                }
            },
            geolocate: function () {
                navigator.geolocation.getCurrentPosition(position => {
                    this.center = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                });
            },
            toApprove(){
                axios
                .post("https://metrics.almejarosa.es/to-verify/approve", this.form)
                .then(response => {
                    window.location.href = "/to-verify";
                });
            },
            sendform() { 
                this.$v.$reset;
                let formData = this.form;

                if(this.status_sustitutas)
                    formData.sustitutas = this.status_sustitutas;
                
                if(this.status_erosguia)
                    formData.erosguia = this.status_erosguia;

                if(this.status_mileroticos)
                    formData.mileroticos = this.status_mileroticos;

                if(this.status_adultguia)
                    formData.adultguia = this.status_adultguia;

                if(this.status_nuevoloquo)
                    formData.nuevoloquo = this.status_nuevoloquo;

                if(this.status_slumi)
                    formData.slumi = this.status_slumi;

                formData.categorypasion = this.categorypasion;

                axios
                .post("https://metrics.almejarosa.es/to-verify/store", formData)
                .then(response => {
                    
                    if(response.data.type == 'error')
                    {
                        this.$modal.show(
                            Notify,
                            {
                                title: "Error",
                                type: "error",
                                //   porterrors: error.response.data.errors,
                                message: response.data.message
                            },
                            {
                                width: 380,
                                height: "auto"
                            }
                        );
                    }else {
                        // window.location.href = "/to-verify";
                        window.location.reload();
                    }
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.$modal.show(
                            Notify,
                            {
                                title: "Error",
                                type: "error",
                                //   porterrors: error.response.data.errors,
                                message: "Try again later"
                            },
                            {
                                width: 380,
                                height: "auto"
                            }
                        );
                    }
                });
            },
            addrate() {
                if (this.form.rates.length < 6) {
                    this.form.rates.push({title: "", price: ""});
                }
            },
            removeRate(id) {
                this.form.rates.splice(id, 1);
            },
            storeServices() {
                if (this.oldservices.length > 0) {
                    this.form.services.forEach((item, index) => {
                        this.oldservices.forEach(service => {
                            if (item.name == service.name) {
                                this.form.services[index].active = true;

                                if (service.childs.length > 0) {
                                    this.form.services[index].active = false;
                                }
                            }
                            if (this.form.services[index].options.length > 0) {
                                this.form.services[index].options.forEach((option, indexer) => {
                                    // service.forEach(child => {
                                    if (service.name == option.name) {
                                        this.form.services[index].options[indexer].active = true;
                                    }
                                    // });
                                });
                            }
                        });
                    });
                }
            },
            storeRemains() {
                if (this.oldremains.length > 0) {
                    this.form.sobres.forEach((item, index) => {
                        this.oldremains.forEach(service => {
                            if (item.name == service.name) {
                                this.form.sobres[index].active = true;
                                if (service.childs.length > 0) {
                                    this.form.sobres[index].active = false;
                                }
                            }

                            if (this.form.sobres[index].options.length > 0) {
                                this.form.sobres[index].options.forEach((option, indexer) => {
                                    // service.childs.forEach(child => {
                                    if (service.name == option.name) {
                                        this.form.sobres[index].options[indexer].active = true;
                                    }
                                    // });
                                });
                            }
                        });
                    });
                }
            }
        },
        mounted() {

            if (this.oldrates.length > 0) {
                this.form.rates = this.oldrates;
            }

            this.storeServices();
            this.storeRemains();

            this.geolocate();

            if(this.form.text.length > 0)
            {
                let text = this.form.text.split("###");

                if(text.length > 0)
                    text.forEach((value, index) => {
                        let key = 'text_' + (index + 1).toString()

                        if(this.form[key] != undefined)
                            this.form[key] = value
                    })
            }
            this.categorypasion = this.post.catsPasion;

            this.status_sustitutas = this.currenttariffs.sustitutas;
            this.status_erosguia = this.currenttariffs.erosguia;
            this.status_mileroticos = this.currenttariffs.mileroticos;
            this.status_adultguia = this.currenttariffs.adultguia;
            this.status_nuevoloquo = this.currenttariffs.nuevoloquo;
            this.status_slumi = this.currenttariffs.slumi;

        },
        computed: {
            sobresCount(){
                const {sobres} = this.form;
                let sobresCounter = 0;
                sobres.map(s => {
                    if (s.options.length === 0 && s.active === true)
                        sobresCounter++;

                    if (s.options.length !== 0)
                        s.options.map(o => {
                            if (o.active === true) sobresCounter++;
                        })
                });

                return sobresCounter;
            },
            isSobres(){
                return this.sobresCount >= 4;
            },

            servicesCount(){
                const {services} = this.form;
                let servicesCounter = 0;
                services.map(s => {
                    if (s.options.length === 0 && s.active === true)
                        servicesCounter++;

                    if (s.options.length !== 0)
                        s.options.map(o => {
                            if (o.active === true) servicesCounter++;
                        })
                });

                return servicesCounter;
            },
            isServices(){
                return this.servicesCount >= 2;
            },

            placesoption() {
                return [...new Set(this.places.map(item => item.string))];
            },
            provinceoption() {
                let array = this.places;
                array = array.filter(data => data.province != null);

                if (this.form.town != "") {
                    array = array.filter(data => data.town == this.form.town);
                }
                return [...new Set(array.map(item => item.province))];
            },
            townoption() {
                let array = this.places;
                array = array.filter(data => data.town != null);

                if (this.form.province != "") {
                    array = array.filter(data => data.province == this.form.province);
                }
                return [...new Set(array.map(item => item.town))];
            }
        }
    };
</script>

<style lang="scss">
    .mt-3
    {
        margin-top: 15px;
    }
	.d-flex
	{
		display: flex;
	}
	
	.input-indicator-box img
	{
		max-width: 25px;
	}
	
    .leaflet-marker-icon {
        margin-left: -13px !important;
        margin-top: -41px !important;
        width: 42px !important;
        height: 41px !important;
    }

    .input-rates:disabled {
        background-color: white;
    }

    .tarif-input-area input[type=text]:disabled
    {
        background-color: #dddddd;
    }
	.text-right
	{
		text-align: right;
		padding-right: 10px;
	}
	.input-dashed-bottom
	{
		border: none;
		border-bottom: 1px dashed #dfdfdf;
		padding-left: 0 !important;
	}
	
	.block-box
	{
		border: 1px solid #dfdfdf;
		width: 100%;
		padding: 15px 5px;
	}
	
	.block-box .w-100
	{
		width: 100%;
	}
	
	.block-box .input-label-title
	{
		border-bottom: 1px solid #dfdfdf;
		padding-bottom: 10px;
		width: 100%;
		display: block;
		font-size: 14px;
	}

    .btn-form.btn-form__cancle.btn-form__withicon.btn_approve
    {
        background-color: #38c172 !important;
    }
</style>

